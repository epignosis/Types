<?php

declare(strict_types=1);

namespace Epignosis\Types\Number;

use InvalidArgumentException;

class NonNegativeInteger extends Integer
{
    protected function validate(int $value): void
    {
        if ($value < 0) {
            throw new InvalidArgumentException('Value must be a non negative integer');
        }
    }
}
