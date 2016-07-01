<?php

declare (strict_types = 1);

namespace UMA\Tests\TightFist\Domain\Model\Budgeting;

use UMA\TightFist\Domain\Model\Budgeting\Budget;
use UMA\TightFist\Domain\Model\Budgeting\MoneyPool;
use UMA\DDD\EventDispatcher\LocalEventDispatcher;

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
