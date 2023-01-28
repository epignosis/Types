<?php

declare(strict_types=1);

namespace Epignosis\Types;

abstract class AbstractType implements TypeInterface
{
    public abstract function getValue();

    final public function equals(TypeInterface $object): bool
    {
        return
            get_class($this) === get_class($object)
            && $this->getValue() === $object->getValue();
    }
}
