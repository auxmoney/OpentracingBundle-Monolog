<?php

declare(strict_types=1);

namespace Auxmoney\OpentracingMonologBundle\Tests\Processor;

use Auxmoney\OpentracingBundle\Factory\TracerFactory;
use Auxmoney\OpentracingBundle\Internal\CachedOpentracing;
use Auxmoney\OpentracingBundle\Internal\Opentracing;
use Auxmoney\OpentracingBundle\Tests\Mock\MockTracer;
use Auxmoney\OpentracingMonologBundle\Processor\MonologTracingHeaderProcessor;
use OpenTracing\Tracer;
use PHPUnit\Framework\TestCase;
use Prophecy\PhpUnit\ProphecyTrait;
use Psr\Log\LoggerInterface;

class MonologTracingHeaderProcessorTest extends TestCase
{
    use ProphecyTrait;

    public function testInvokeNoSpan(): void
    {
        $tracer = $this->prophesize(Tracer::class);
        $tracer->getActiveSpan()->willReturn(null);
        $tracerFactory = $this->prophesize(TracerFactory::class);
        $tracerFactory->create(
            'project name',
            'agent host',
            'agent port',
            'Jaeger\Sampler\ConstSampler',
            '"true"'
        )->willReturn($tracer->reveal());
        $opentracing = new CachedOpentracing(
            $tracerFactory->reveal(),
            $this->prophesize(LoggerInterface::class)->reveal(),
            'project name',
            'agent host',
            'agent port',
            'Jaeger\Sampler\ConstSampler',
            '"true"'
        );

        $subject = new MonologTracingHeaderProcessor($opentracing);

        $record = $subject(['message' => 'logged something']);

        self::assertArrayNotHasKey('extra', $record);
    }

    public function testInvoke(): void
    {
        $tracer = new MockTracer();
        $tracer->startActiveSpan('span');
        $opentracing = $this->prophesize(Opentracing::class);
        $opentracing->getTracerInstance()->willReturn($tracer);

        $subject = new MonologTracingHeaderProcessor($opentracing->reveal());

        $record = $subject(['message' => 'logged something']);

        self::assertArrayHasKey('extra', $record);
        self::assertArrayHasKey('opentracing-context', $record['extra']);
        self::assertSame('{"made_up_header":"1:2:3:4"}', $record['extra']['opentracing-context']);
    }
}
