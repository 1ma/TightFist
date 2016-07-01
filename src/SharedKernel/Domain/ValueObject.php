<?php

declare(strict_types = 1);

namespace UMA\TightFist\SharedKernel\Domain;

interface ValueObject
{
    public function equals(ValueObject $object): bool;
}
