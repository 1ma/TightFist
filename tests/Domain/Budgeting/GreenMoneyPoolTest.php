<?php

declare (strict_types = 1);

namespace UMA\Tests\TightFist\Domain\Budgeting;

use UMA\TightFist\Domain\Budgeting\Budget;
use UMA\TightFist\Domain\Budgeting\GreenMoneyPool;

class GreenMoneyPoolTest extends \PHPUnit_Framework_TestCase
{
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
}
