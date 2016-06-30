<?php

namespace UMA\Tests\TightFist\Context\Budgeting\Domain;

use UMA\TightFist\Context\Budgeting\Domain\Model\Budget\Budget;
use UMA\TightFist\Context\Budgeting\Domain\Model\MoneyPool\GreenMoneyPool;
use UMA\TightFist\SharedKernel\EventDispatcher\LocalEventDispatcher;

class GreenMoneyPoolTest extends \PHPUnit_Framework_TestCase
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
    public function cannotOverdraft()
    {
        $this->expectException(\RuntimeException::class);

        $pool = new GreenMoneyPool($this->budget);
        $pool->debit(100);
    }

    /**
     * @test
     */
    public function cannotInstantiateOverdrafted()
    {
        $this->expectException(\InvalidArgumentException::class);

        new GreenMoneyPool($this->budget, -100);
    }

    /**
     * @test
     */
    public function isNotPlainMoneyPool()
    {
        $pool = new GreenMoneyPool($this->budget, 100);

        $creditedPool = $pool->credit(25);
        $this->assertSame(125, $creditedPool->getBalance());
        $this->assertInstanceOf(GreenMoneyPool::class, $creditedPool);

        $debitedPool = $pool->debit(25);
        $this->assertSame(75, $debitedPool->getBalance());
        $this->assertInstanceOf(GreenMoneyPool::class, $debitedPool);
    }
}
