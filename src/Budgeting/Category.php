<?php

declare (strict_types = 1);

namespace UMA\TightFist\Budgeting;

use UMA\TightFist\Money\Money;

class Category
{
    private $budget;

    private $name;

    private $balance;

    public function __construct(Budget $budget, string $name)
    {
        $this->budget = $budget;
        $this->name = $name;
        $this->balance = Money::make(0);
    }

    public function lump(Money $money): Category
    {
        $this->balance = $money->lump($this->balance);

        return $this;
    }

    public function getCurrentBalance(): Money
    {
        return $this->balance;
    }
}
