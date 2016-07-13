<?php

declare (strict_types = 1);

namespace UMA\TightFist\Domain\Bookkeeping;

use Doctrine\Common\Collections\ArrayCollection;
use UMA\DDD\Foundation\AggregateRoot;
use UMA\DDD\Foundation\UUID;
use UMA\TightFist\Domain\Budgeting\Budget;
use UMA\TightFist\Domain\Budgeting\Category;
use UMA\TightFist\Domain\Money\Credit;
use UMA\TightFist\Domain\Money\Debit;
use UMA\TightFist\Domain\Money\Money;

class Account implements AggregateRoot
{
    /**
     * @var UUID
     */
    private $id;

    /**
     * @var Money
     */
    private $balance;

    /**
     * @var Budget|null
     */
    private $budget;

    /**
     * @var Transaction[]
     */
    private $transactions;

    /**
     * @param Budget|null $budget
     */
    public function __construct(Budget $budget = null)
    {
        $this->id = new UUID();
        $this->balance = Money::make(0);
        $this->budget = $budget;
        $this->transactions = new ArrayCollection();
    }

    public function getId(): UUID
    {
        return $this->id;
    }

    /**
     * @param \DateTime     $date     The day in which the Transaction took place
     * @param Money         $amount   The amount of money involved
     * @param string        $memo     A short description for the transaction
     * @param Category|null $category Spending Category for the Transaction.
     *
     * @throws \DomainException When any of the Category business rules is not honored.
     */
    public function recordNewTransaction(\DateTime $date, Money $amount, string $memo, Category $category = null)
    {
        try {
            $txBuilder = new TransactionBuilder($this, $date, $amount, $memo);

            if (null !== $category) {
                $txBuilder->setCategory($category);
            }

            $transaction = $txBuilder->build();
        } catch (\DomainException $e) {
            throw $e; // TODO reassess
        }


        if (null !== $this->budget) {
            if ($amount instanceof Credit) {
                $this->budget->earn($amount);
            } else {
                /** @var Debit $amount */
                $this->budget->spend($category->getName(), $amount);
            }
        }

        $this->balance = $amount->lump($this->balance);
        $this->transactions->add($transaction);
    }

    public function getBudget(): Budget
    {
        return $this->budget;
    }
}
