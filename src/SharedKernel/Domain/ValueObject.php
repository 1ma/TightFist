<?php

namespace UMA\TightFist\SharedKernel\Domain;

interface ValueObject
{
    public function equals(ValueObject $object): bool;
}
