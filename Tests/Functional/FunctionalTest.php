<?php

declare(strict_types=1);

namespace Auxmoney\OpentracingMonologBundle\Tests\Functional;

use Auxmoney\OpentracingBundle\Tests\Functional\JaegerConsoleFunctionalTest;
use Symfony\Component\Process\Process;

class FunctionalTest extends JaegerConsoleFunctionalTest
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
}
