<?php

declare(strict_types=1);

namespace Epignosis\Types\Number;

use InvalidArgumentException;

class PositiveInteger extends Integer
{
    public function __construct(int $value)
    {
        if ($value <= 0) {
            throw new InvalidArgumentException('Value must be a positive integer');
        }

        parent::__construct($value);
    }
}
