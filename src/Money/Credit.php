<?php

declare (strict_types = 1);

namespace UMA\TightFist\Money;

class Credit extends Money
{
    public function __construct(int $amount)
    {
        if (0 > $amount) {
            throw new \DomainException('a Credit must have a zero or positive amount');
        }

        parent::__construct($amount);
    }
}
