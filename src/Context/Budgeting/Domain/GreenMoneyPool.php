<?php

namespace UMA\TightFist\Context\Budgeting\Domain;

/**
 * The GreenMoneyPool is special MoneyPool that cannot
 * hold a negative balance.
 */
class GreenMoneyPool extends MoneyPool
{
    public function __construct(int $startingBalance = 0)
    {
        if (0 > $startingBalance) {
            throw new \InvalidArgumentException('fuck you, you cannot create a GreenMoneyPool instance with a negative starting balance');
        }

        parent::__construct($startingBalance);
    }

    /**
     * {@inheritdoc}
     */
    public function credit(int $amount): MoneyPool
    {
        return new self((parent::credit($amount)->getBalance()));
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

        return new self((parent::debit($amount)->getBalance()));
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
