<?php

namespace UMA\Tests\TightFist\Domain\Model;

use UMA\TightFist\Domain\Model\Debit;
use UMA\TightFist\Domain\Model\Money;

class MoneyTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function simpleCalculations()
    {
        $prop = new \ReflectionProperty(Money::class, 'amount');
        $prop->setAccessible(true);

        $debitOne = Money::make(-100);
        $debitTwo = Money::make(-50);

        $internalValue = $prop->getValue($result = $debitOne->lump($debitTwo));

        $this->assertSame(-150, $internalValue);
        $this->assertInstanceOf(Debit::class, $result);
    }
}
