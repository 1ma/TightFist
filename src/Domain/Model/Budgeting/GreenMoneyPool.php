<?php

declare (strict_types = 1);

namespace UMA\TightFist\Domain\Model\Budgeting;

/**
 * The GreenMoneyPool is special MoneyPool that cannot
 * hold a negative balance.
 */
class GreenMoneyPool extends MoneyPool
{
    public function __construct(Budget $budget, int $startingBalance = 0)
    {
        if (0 > $startingBalance) {
            throw new \InvalidArgumentException('fuck you, you cannot create a GreenMoneyPool instance with a negative starting balance');
        }

        parent::__construct($budget, $startingBalance);
    }

    /**
     * {@inheritdoc}
     */
    public function credit(int $amount): MoneyPool
    {
        return new self($this->getBudget(), parent::credit($amount)->getBalance());
    }

    /**
     * {@inheritdoc}
     *
     * @throws \RuntimeException
     */
    public function debit(int $amount): MoneyPool
    {
        if ($this->overdraft($amount)) {
            throw new \RuntimeException('fuck you, you cannot debit more funds than what the balance holds');
        }

        return new self($this->getBudget(), parent::debit($amount)->getBalance());
    }

    /**
     * @param int $amount
     *
     * @return bool
     */
    private function overdraft(int $amount): bool
    {
        return $this->getBalance() < $amount;
    }
}
