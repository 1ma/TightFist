<?php

declare(strict_types = 1);

namespace UMA\Tests\TightFist\Domain\Bookkeeping;

use UMA\TightFist\Domain\Bookkeeping\Account;
use UMA\TightFist\Domain\Bookkeeping\Transaction;
use UMA\TightFist\Domain\Bookkeeping\TransactionBuilder;
use UMA\TightFist\Domain\Budgeting\Budget;
use UMA\TightFist\Domain\Money\Money;

class TransactionBuilderTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Account
     */
    private $budgetedAccount;

    /**
     * @var Account
     */
    private $unbudgetedAccount;

    protected function setUp()
    {
        $budget = (new Budget())
            ->createCategory('food');

        $this->budgetedAccount = new Account($budget);
        $this->unbudgetedAccount = new Account();
    }

    /**
     * @test
     * @dataProvider simpleHappyPathProvider
     */
    public function simpleHappyPath(bool $useBudgetedAccount, Money $money)
    {
        $builder = new TransactionBuilder(
            $useBudgetedAccount ? $this->budgetedAccount : $this->unbudgetedAccount,
            new \DateTime('today'), $money, 'Some (hopefully) relevant info'
        );

        $transaction = $builder->build();

        $this->assertInstanceOf(Transaction::class, $transaction);
    }

    public function simpleHappyPathProvider()
    {
        return [
            'credit transaction in unbudgeted account' => [false, Money::make(100)],
            'debit transaction in unbudgeted account' => [false, Money::make(-100)],
            'credit transaction in a budgeted account' => [true, Money::make(100)],
        ];
    }

    /**
     * @test
     */
    public function simpleSadPath()
    {
        $this->expectException(\DomainException::class);

        $builder = new TransactionBuilder(
            $this->budgetedAccount, new \DateTime('today'), Money::make(-100), 'Some (hopefully) relevant info'
        );

        $builder->build();
    }
}
