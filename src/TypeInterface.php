<?php

namespace Epignosis\Types;

interface TypeInterface
{
    /**
     * @return mixed
     */
    public function getValue();

    public function equals(TypeInterface $object): bool;
}
