<?php

namespace UMA\TightFist\Domain\Model\Budgeting;

use UMA\TightFist\SharedKernel\Domain\UUID;

/**
 * The MoneyPool is an immutable value object.
 */
class MoneyPool
{
    /**
     * @var UUID
     */
    private $id;

    /**
     * @var Budget
     */
    private $budget;

    /**
     * @var int
     */
    private $balance;

    /**
     * @param Budget $budget
     * @param int    $startingBalance
     */
    public function __construct(Budget $budget, int $startingBalance = 0)
    {
        $this->id = new UUID();
        $this->budget = $budget;
        $this->balance = $startingBalance;
    }

    /**
     * @return Budget
     */
    public function getBudget(): Budget
    {
        return $this->budget;
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

        return new self($this->budget, $this->balance + $amount);
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

        return new self($this->budget, $this->balance - $amount);
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
