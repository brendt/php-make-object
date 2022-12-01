<?php

declare(strict_types=1);

namespace Brendt\Make\Processors;

interface ProcessorAwareInterface
{
    public function setProcessor(Processor $processor): void;
}
