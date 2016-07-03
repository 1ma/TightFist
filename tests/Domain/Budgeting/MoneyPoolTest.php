<?php

declare (strict_types = 1);

namespace UMA\Tests\TightFist\Domain\Budgeting;

use UMA\TightFist\Domain\Budgeting\Budget;
use UMA\TightFist\Domain\Budgeting\MoneyPool;

class MoneyPoolTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function negativeCreditAmount()
    {
        $this->expectException(\InvalidArgumentException::class);

        $pool = new MoneyPool(new Budget());
        $pool->credit(-100);
    }

    /**
     * @test
     */
    public function negativeDebitAmount()
    {
        $this->expectException(\InvalidArgumentException::class);

        $pool = new MoneyPool(new Budget());
        $pool->debit(-100);
    }
}
