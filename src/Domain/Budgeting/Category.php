<?php

declare (strict_types = 1);

namespace UMA\TightFist\Domain\Budgeting;

use UMA\DDD\Foundation\Entity;
use UMA\TightFist\Domain\Money\Money;

class Category implements Entity
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

    public function getBudget(): Budget
    {
        return $this->budget;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getCurrentBalance(): Money
    {
        return $this->balance;
    }
}
