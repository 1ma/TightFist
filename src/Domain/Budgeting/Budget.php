<?php

declare (strict_types = 1);

namespace UMA\TightFist\Domain\Budgeting;

use UMA\DDD\EventDispatcher\DomainEventDispatcher;
use UMA\DDD\Foundation\AggregateRoot;
use UMA\DDD\Foundation\UUID;

class Budget implements AggregateRoot
{
    /**
     * @var UUID
     */
    private $id;

    /**
     * @var GreenMoneyPool
     */
    private $idlePool;

    /**
     * @var MoneyPool[]
     */
    private $items;

    public function __construct()
    {
        $this->id = new UUID();
        $this->idlePool = new GreenMoneyPool();
        $this->items = [];

        DomainEventDispatcher::getInstance()->dispatch(
            new BudgetCreated($this->getId())
        );
    }

    public function getId(): UUID
    {
        return $this->id;
    }

    public function addItem(string $item): Budget
    {
        if (isset($this->items[$item])) {
            throw new \RuntimeException('fuck you, you cannot override an existing item');
        }

        $this->items[$item] = new MoneyPool();

        return $this;
    }

    public function discardItem(string $item): Budget
    {
        if (!isset($this->items[$item])) {
            throw new \RuntimeException('fuck you, you cannot discard a nonexistent item');
        }

        $this->idlePool = $this->idlePool->credit($this->items[$item]->getBalance());

        unset($this->items[$item]);

        return $this;
    }

    public function getIdleBalance(): int
    {
        return $this->idlePool->getBalance();
    }

    public function getItemBalance(string $item): int
    {
        if (!isset($this->items[$item])) {
            throw new \RuntimeException('fuck you, you cannot inspect the balance of an item that does not exist');
        }

        return $this->items[$item]->getBalance();
    }

    public function earn(int $amount): Budget
    {
        $this->idlePool = $this->idlePool->credit($amount);

        return $this;
    }

    public function spend(string $item, int $amount): Budget
    {
        if (!isset($this->items[$item])) {
            throw new \RuntimeException('fuck you, you cannot spend money from an item that does not exist');
        }

        $this->items[$item] = $this->items[$item]->debit($amount);

        return $this;
    }

    public function allocate(string $item, int $amount): Budget
    {
        if (!isset($this->items[$item])) {
            throw new \RuntimeException('fuck you, you cannot assign funds to an item that does not exist');
        }

        $this->idlePool = $this->idlePool->debit($amount);
        $this->items[$item] = $this->items[$item]->credit($amount);

        return $this;
    }

    public function reallocate(string $src, string $dst, int $amount): Budget
    {
        if (!isset($this->items[$src]) || !isset($this->items[$dst])) {
            throw new \RuntimeException('fuck you, you cannot relocate funds to and/or from items that do not exist');
        }

        $this->items[$src] = $this->items[$src]->debit($amount);
        $this->items[$dst] = $this->items[$dst]->credit($amount);

        return $this;
    }

    public function deallocate(string $item, int $amount): Budget
    {
        if (!isset($this->items[$item])) {
            throw new \RuntimeException('fuck you, you cannot deallocate funds from a non existent item');
        }

        $this->items[$item]->debit($amount);
        $this->idlePool->credit($amount);

        return $this;
    }
}
