<?php

declare(strict_types=1);

namespace Auxmoney\OpentracingMonologBundle\Tests\Functional;

use Auxmoney\OpentracingBundle\Tests\Functional\JaegerFunctionalTest;
use Symfony\Component\Process\Process;

class FunctionalTest extends JaegerFunctionalTest
{
    public function testTraceContextInLog(): void
    {
        $this->setUpTestProject('default');

        $process = new Process(['symfony', 'console', 'test:monolog'], 'build/testproject');
        $process->mustRun();
        $output = $process->getOutput();
        $traceId = substr($output, 0, strpos($output, ':'));
        self::assertNotEmpty($traceId);

        $logFileContent = file_get_contents('build/testproject/var/log/dev.log');
        self::assertContains($traceId, $logFileContent);
    }

    protected function setUpTestProject(string $projectSetup): void
    {
        $this->copyTestProjectFiles($projectSetup);

        $this->composerDumpAutoload();
        $this->consoleCacheClear();
    }

    protected function tearDown()
    {
        $this->gitResetTestProject();
        $this->dockerStopJaeger();
    }
}
