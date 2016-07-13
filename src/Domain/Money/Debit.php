<?php

declare (strict_types = 1);

namespace UMA\TightFist\Domain\Money;

class Debit extends Money
{
    public function __construct($amount)
    {
        if (0 <= $amount) {
            throw new \DomainException('a Debit must have a negative amount');
        }

        parent::__construct($amount);
    }
}
