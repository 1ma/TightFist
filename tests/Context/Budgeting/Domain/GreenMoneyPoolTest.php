<?php

namespace UMA\Tests\TightFist\Context\Budgeting\Domain;

use UMA\TightFist\Context\Budgeting\Domain\GreenMoneyPool;

class GreenMoneyPoolTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function cannotOverdraft()
    {
        $this->expectException(\RuntimeException::class);

        $pool = new GreenMoneyPool();
        $pool->debit(100);
    }

    /**
     * @test
     */
    public function cannotInstantiateOverdrafted()
    {
        $this->expectException(\InvalidArgumentException::class);

        new GreenMoneyPool(-100);
    }

    /**
     * @test
     */
    public function isNotPlainMoneyPool()
    {
        $pool = new GreenMoneyPool(100);

        $creditedPool = $pool->credit(25);
        $this->assertSame(125, $creditedPool->getBalance());
        $this->assertInstanceOf(GreenMoneyPool::class, $creditedPool);

        $debitedPool = $pool->debit(25);
        $this->assertSame(75, $debitedPool->getBalance());
        $this->assertInstanceOf(GreenMoneyPool::class, $debitedPool);
    }
}
