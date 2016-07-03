<?php

declare (strict_types = 1);

namespace UMA\Tests\TightFist\Domain;

use UMA\TightFist\Domain\Model\GreenMoneyPool;

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
}
