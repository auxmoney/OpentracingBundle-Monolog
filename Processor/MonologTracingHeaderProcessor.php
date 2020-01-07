<?php

declare(strict_types=1);

namespace Auxmoney\OpentracingBundleMonolog\Processor;

use Auxmoney\OpentracingBundle\Internal\Opentracing;
use const OpenTracing\Formats\TEXT_MAP;

final class MonologTracingHeaderProcessor
{
    private $opentracing;

    public function __construct(Opentracing $opentracing)
    {
        $this->opentracing = $opentracing;
    }

    /**
     * @param array<string,mixed> $record
     * @return array<string,mixed>
     */
    public function __invoke(array $record): array
    {
        $span = $this->opentracing->getTracerInstance()->getActiveSpan();
        if ($span) {
            $context = [];
            $this->opentracing->getTracerInstance()->inject(
                $span->getContext(),
                TEXT_MAP,
                $context
            );
            $record['extra']['opentracing-context'] = json_encode($context);
        }
        return $record;
    }
}
