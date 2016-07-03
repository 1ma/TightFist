<?php

namespace UMA\TightFist\Domain\Model;

use UMA\DDD\Foundation\Entity;
use UMA\DDD\Foundation\UUID;

/**
 * The MoneyPool is an immutable value object.
 */
class MoneyPool implements Entity
{
    /**
     * @var UUID
     */
    private $id;

    /**
     * @var int
     */
    private $balance;

    /**
     * @param int $startingBalance
     */
    public function __construct(int $startingBalance = 0)
    {
        $this->id = new UUID();
        $this->balance = $startingBalance;
    }

    public function getId(): UUID
    {
        return $this->id;
    }

    /**
     * @return int
     */
    public function getBalance(): int
    {
        return $this->balance;
    }

    /**
     * @param int $amount
     *
     * @return MoneyPool
     *
     * @throws \InvalidArgumentException
     */
    public function credit(int $amount): MoneyPool
    {
        $this->assertPositiveAmount($amount);

        $this->balance += $amount;

        return $this;
    }

    /**
     * @param int $amount
     *
     * @return MoneyPool
     *
     * @throws \InvalidArgumentException
     */
    public function debit(int $amount): MoneyPool
    {
        $this->assertPositiveAmount($amount);

        $this->balance -= $amount;

        return $this;
    }

    /**
     * @param int $amount
     *
     * @throws \InvalidArgumentException
     */
    private function assertPositiveAmount(int $amount)
    {
        if (0 > $amount) {
            throw new \InvalidArgumentException('fuck you, a negative amount? Gimme a break');
        }
    }
}
