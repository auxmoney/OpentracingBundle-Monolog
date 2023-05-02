<?php

declare(strict_types=1);

namespace Auxmoney\OpentracingMonologBundle\Processor;

use ArrayAccess;
use Auxmoney\OpentracingBundle\Internal\Opentracing;

use const OpenTracing\Formats\TEXT_MAP;

final class MonologTracingHeaderProcessor
{
    private Opentracing $opentracing;

    public function __construct(Opentracing $opentracing)
    {
        $this->opentracing = $opentracing;
    }

    /**
     * @param ArrayAccess<string,mixed>|array<string,mixed> $record
     * @return ArrayAccess<string,mixed>|array<string,mixed>
     */
    public function __invoke(ArrayAccess|array $record): ArrayAccess|array
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
