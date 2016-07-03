<?php

declare (strict_types = 1);

namespace UMA\TightFist\Domain\Budgeting;

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
     *
     * @throws \RuntimeException
     */
    public function debit(int $amount): MoneyPool
    {
        if ($this->overdraft($amount)) {
            throw new \RuntimeException('fuck you, you cannot debit more funds than what the balance holds');
        }

        return parent::debit($amount);
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
