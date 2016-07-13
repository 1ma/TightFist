<?php

declare (strict_types = 1);

namespace UMA\TightFist\Domain\Bookkeeping;

use UMA\DDD\Foundation\Entity;
use UMA\DDD\Foundation\UUID;
use UMA\TightFist\Domain\Budgeting\Category;
use UMA\TightFist\Domain\Money\Money;

class Transaction implements Entity
{
    private $id;

    private $account;

    private $category;

    private $amount;

    private $date;

    private $memo;

    public function __construct(Account $account, Money $amount, \DateTime $date, string $memo, Category $category = null)
    {
        $this->id = new UUID();
        $this->account = $account;
        $this->category = $category;
        $this->amount = $amount;
        $this->date = $date;
        $this->memo = $memo;
    }

    public function getId(): UUID
    {
        return $this->id;
    }
}
