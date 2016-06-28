<?php

namespace UMA\Tests\TightFist\Context\Budgeting\Domain;

use UMA\TightFist\Context\Budgeting\Domain\MoneyPool;

class MoneyPoolTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function immutability()
    {
        $pool = new MoneyPool();
        $anotherPool = $pool->credit(100)->debit(100);

        $this->assertEquals($pool, $anotherPool);
        $this->assertNotSame($pool, $anotherPool);
    }

    /**
     * @test
     */
    public function negativeCreditAmount()
    {
        $this->expectException(\InvalidArgumentException::class);

        $pool = new MoneyPool();
        $pool->credit(-100);
    }

    /**
     * @test
     */
    public function negativeDebitAmount()
    {
        $this->expectException(\InvalidArgumentException::class);

        $pool = new MoneyPool();
        $pool->debit(-100);
    }

    /**
     * @test
     */
    public function testZeroCreditAmount()
    {
        $this->expectException(\InvalidArgumentException::class);

        $pool = new MoneyPool();
        $pool->credit(0);
    }

    /**
     * @test
     */
    public function testZeroDebitAmount()
    {
        $this->expectException(\InvalidArgumentException::class);

        $pool = new MoneyPool();
        $pool->debit(0);
    }
}
