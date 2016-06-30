<?php

namespace UMA\Tests\TightFist\Context\Budgeting\Domain;

use UMA\TightFist\Context\Budgeting\Domain\Model\Budget\Budget;
use UMA\TightFist\Context\Budgeting\Domain\Model\MoneyPool\MoneyPool;
use UMA\TightFist\SharedKernel\EventDispatcher\LocalEventDispatcher;

class MoneyPoolTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Budget
     */
    private $budget;

    protected function setUp()
    {
        $this->budget = new Budget(new LocalEventDispatcher());
    }

    /**
     * @test
     */
    public function negativeCreditAmount()
    {
        $this->expectException(\InvalidArgumentException::class);

        $pool = new MoneyPool($this->budget);
        $pool->credit(-100);
    }

    /**
     * @test
     */
    public function negativeDebitAmount()
    {
        $this->expectException(\InvalidArgumentException::class);

        $pool = new MoneyPool($this->budget);
        $pool->debit(-100);
    }
}
