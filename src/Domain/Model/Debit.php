<?php

namespace UMA\TightFist\Domain\Model;

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
