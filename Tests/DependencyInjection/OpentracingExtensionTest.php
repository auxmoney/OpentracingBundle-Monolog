<?php

declare(strict_types=1);

namespace Auxmoney\OpentracingMonologBundle\Tests\DependencyInjection;

use Auxmoney\OpentracingMonologBundle\DependencyInjection\OpentracingMonologExtension;
use Auxmoney\OpentracingMonologBundle\Processor\MonologTracingHeaderProcessor;
use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class OpentracingExtensionTest extends TestCase
{
    private $subject;

    public function setUp(): void
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
