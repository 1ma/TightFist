<?php

namespace UMA\TightFist\Domain\Bookkeeping;

use UMA\TightFist\Domain\Budgeting\Category;
use UMA\TightFist\Domain\Money\Credit;
use UMA\TightFist\Domain\Money\Debit;
use UMA\TightFist\Domain\Money\Money;

class TransactionBuilder
{
    private $account;

    private $category;

    private $amount;

    private $date;

    private $memo;

    public function __construct(Account $account, \DateTime $date, Money $amount, string $memo)
    {
        $this->account = $account;
        $this->date = $date;
        $this->amount = $amount;
        $this->memo = $memo;
    }

    /**
     * @throws \DomainException
     */
    public function setCategory(Category $category): TransactionBuilder
    {
        if (null === $this->account->getBudget()) {
            throw new \DomainException('Die Account is not part of a Budget, so its Transaction cannot have a spending Category');
        }

        if ($this->amount instanceof Credit) {
            throw new \DomainException('In order to pass a Category to the Transaction, its amount must be a Debit');
        }

        if ($this->account->getBudget() !== $category->getBudget()) {
            throw new \DomainException('Die Category must belong to the same budget as the Account');
        }

        $this->category = $category;

        return $this;
    }

    /**
     * @throws \DomainException
     */
    public function build(): Transaction
    {
        if (null === $this->category) {
            if ($this->amount instanceof Debit && null !== $this->account->getBudget()) {
                throw new \DomainException('Die new debit Transaction must have a spending Category because the Account is part of a Budget');
            }

            return new Transaction($this->account, $this->amount, $this->date, $this->memo);
        }

        return new Transaction($this->account, $this->amount, $this->date, $this->memo, $this->category);
    }
}
