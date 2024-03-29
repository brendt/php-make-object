<?php

declare(strict_types=1);

namespace Brendt\Make\Mappers;

use Exception;

final class CannotMap extends Exception
{
    public function __construct(string $message)
    {
        parent::__construct($message);
    }
}
