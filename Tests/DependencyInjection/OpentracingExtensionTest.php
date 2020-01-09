<?php

declare(strict_types=1);

namespace Auxmoney\OpentracingBundleMonolog\Tests\DependencyInjection;

use Auxmoney\OpentracingBundleMonolog\DependencyInjection\OpentracingMonologExtension;
use Auxmoney\OpentracingBundleMonolog\Processor\MonologTracingHeaderProcessor;
use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class OpentracingExtensionTest extends TestCase
{
    private $subject;

    public function setUp()
    {
        parent::setUp();

        $this->subject = new OpentracingMonologExtension();
    }

    public function testLoad(): void
    {
        $container = new ContainerBuilder();

        $this->subject->load([], $container);

        self::assertArrayHasKey(MonologTracingHeaderProcessor::class, $container->getDefinitions());
    }
}
