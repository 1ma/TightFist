<?php

declare (strict_types = 1);

namespace UMA\TightFist\Budgeting;

use UMA\DDD\Foundation\AggregateRoot;
use UMA\DDD\Foundation\UUID;
use UMA\TightFist\Money\Credit;
use UMA\TightFist\Money\Debit;
use UMA\TightFist\Money\Money;

class Budget implements AggregateRoot
{
    /**
     * @var UUID
     */
    private $id;

    /**
     * @var Money
     */
    private $unassigned;

    /**
     * @var Money[]
     */
    private $categories;

    public function __construct()
    {
        $this->id = new UUID();
        $this->unassigned = Money::make(0);
        $this->categories = [];
    }

    /**
     * @return UUID
     */
    public function getId(): UUID
    {
        return $this->id;
    }

    public function createCategory(string $categoryName): Budget
    {
        $this->categories[$categoryName] = Money::make(0);

        return $this;
    }

    public function earn(Credit $amount): Budget
    {
        $this->unassigned = $amount->lump($this->unassigned);

        return $this;
    }

    public function assign(string $categoryName, Credit $credit): Budget
    {
        $this->unassigned = $credit->mirror()->lump($this->unassigned);
        $this->categories[$categoryName] = $credit->lump($this->categories[$categoryName]);

        return $this;
    }

    public function spend(string $categoryName, Debit $amount): Budget
    {
        $this->categories[$categoryName] = $amount->lump($this->categories[$categoryName]);

        return $this;
    }
}
