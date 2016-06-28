<?php

namespace UMA\TightFist\Context\Budgeting\Domain;

/**
 * The MoneyPool is an immutable value object
 */
class MoneyPool
{
    /**
     * @var int
     */
    private $balance;

    /**
     * @param int $startingBalance
     */
    public function __construct(int $startingBalance = 0)
    {
        $this->balance = $startingBalance;
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
        $this->assertValidAmount($amount);

        return new self($this->balance + $amount);
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
        $this->assertValidAmount($amount);

        return new self($this->balance - $amount);
    }

    /**
     * @param int $amount
     *
     * @throws \InvalidArgumentException
     */
    private function assertValidAmount(int $amount)
    {
        if (0 === $amount) {
            throw new \InvalidArgumentException("fuck you, don't waste my time");
        }

        if (0 > $amount) {
            throw new \InvalidArgumentException('fuck you, a negative amount? Gimme a break');
        }
    }
}
