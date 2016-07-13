<?php

declare (strict_types = 1);

namespace UMA\TightFist\Domain\Budgeting;

use Doctrine\Common\Collections\ArrayCollection;
use UMA\DDD\Foundation\AggregateRoot;
use UMA\DDD\Foundation\UUID;
use UMA\TightFist\Domain\Money\Credit;
use UMA\TightFist\Domain\Money\Debit;
use UMA\TightFist\Domain\Money\Money;

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
     * @var Category[]
     */
    private $categories;

    public function __construct()
    {
        $this->id = new UUID();
        $this->unassigned = Money::make(0);
        $this->categories = new ArrayCollection();
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
        $this->categories->set($categoryName, new Category($this, $categoryName));

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
        $this->categories->get($categoryName)->lump($credit);

        return $this;
    }

    public function spend(string $categoryName, Debit $amount): Budget
    {
        $this->categories->get($categoryName)->lump($amount);

        return $this;
    }
}
