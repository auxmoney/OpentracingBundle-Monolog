<?php

declare(strict_types=1);

namespace Auxmoney\OpentracingMonologBundle\Tests\Functional;

use Auxmoney\OpentracingBundle\Tests\Functional\JaegerFunctionalTest;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Process\Process;

class FunctionalTest extends JaegerFunctionalTest
{
    public function testTraceContextInLog(): void
    {
        $this->setUpTestProject('default');

        $p = new Process(['symfony', 'console', 'test:monolog'], 'build/testproject');
        $p->mustRun();
        $output = $p->getOutput();
        $traceId = substr($output, 0, strpos($output, ':'));
        self::assertNotEmpty($traceId);

        $logFileContent = file_get_contents('build/testproject/var/log/dev.log');
        self::assertContains($traceId, $logFileContent);
    }

    protected function setUpTestProject(string $projectSetup): void
    {
        $filesystem = new Filesystem();
        $filesystem->mirror(sprintf('Tests/Functional/TestProjectFiles/%s/', $projectSetup), 'build/testproject/');

        $p = new Process(['composer', 'dump-autoload'], 'build/testproject');
        $p->mustRun();
        $p = new Process(['symfony', 'console', 'cache:clear'], 'build/testproject');
        $p->mustRun();
    }

    protected function tearDown()
    {
        $p = new Process(['git', 'reset', '--hard', 'reset'], 'build/testproject');
        $p->mustRun();
        $p = new Process(['docker', 'stop', 'jaeger']);
        $p->mustRun();
    }
}
