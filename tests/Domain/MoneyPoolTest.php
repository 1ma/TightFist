<?php

declare (strict_types = 1);

namespace UMA\Tests\TightFist\Domain;

use UMA\TightFist\Domain\Model\MoneyPool;

class MoneyPoolTest extends \PHPUnit_Framework_TestCase
{
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
}
