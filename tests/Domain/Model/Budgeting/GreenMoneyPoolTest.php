<?php

declare (strict_types = 1);

namespace UMA\Tests\TightFist\Domain\Model\Budgeting;

use UMA\TightFist\Domain\Model\Budgeting\Budget;
use UMA\TightFist\Domain\Model\Budgeting\GreenMoneyPool;
use UMA\DDD\EventDispatcher\GenericEventDispatcher;

class GreenMoneyPoolTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Budget
     */
    private $budget;

    protected function setUp()
    {
        $this->budget = new Budget(new GenericEventDispatcher());
    }

    /**
     * @test
     */
    public function cannotOverdraft()
    {
        $this->expectException(\RuntimeException::class);

        $pool = new GreenMoneyPool(new Budget());
        $pool->debit(100);
    }

    /**
     * @test
     */
    public function cannotInstantiateOverdrafted()
    {
        $this->expectException(\InvalidArgumentException::class);

        new GreenMoneyPool(new Budget(), -100);
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
