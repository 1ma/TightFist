<?php

declare (strict_types = 1);

namespace UMA\Tests\TightFist\Money;

use UMA\TightFist\Money\Credit;
use UMA\TightFist\Money\Debit;
use UMA\TightFist\Money\Money;

class MoneyTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     * @dataProvider makeProvider
     */
    public function make(int $amount, string $expectedClass)
    {
        $this->assertInstanceOf($expectedClass, Money::make($amount));
    }

    public function makeProvider(): array
    {
        return [
            'make a credit' => [100, Credit::class],
            'make a debit' => [-100, Debit::class],
            'make a zero Money object (considered Credit by convention)' => [0, Credit::class],
        ];
    }

    /**
     * @test
     * @dataProvider mirrorProvider
     */
    public function mirror(int $amount, string $expectedClass)
    {
        $this->assertInstanceOf($expectedClass, $mirror = Money::make($amount)->mirror());

        $prop = new \ReflectionProperty(Money::class, 'amount');
        $prop->setAccessible(true);

        $this->assertSame(0, $amount + $prop->getValue($mirror));
    }

    public function mirrorProvider(): array
    {
        return [
            'mirror a credit' => [100, Debit::class],
            'mirror a debit' => [-100, Credit::class],
            'mirror a zero Money object' => [0, Credit::class]
        ];
    }

    /**
     * @test
     * @dataProvider lumpProvider
     */
    public function lump(int $amountOne, int $amountTwo, int $expectedAmount, string $expectedClass)
    {
        $prop = new \ReflectionProperty(Money::class, 'amount');
        $prop->setAccessible(true);

        $internalAmount = $prop->getValue(
            $money = Money::make($amountOne)->lump(Money::make($amountTwo))
        );

        $this->assertSame($expectedAmount, $internalAmount);
        $this->assertInstanceOf($expectedClass, $money);
    }

    public function lumpProvider(): array
    {
        return [
            'lump two credits' => [100, 100, 200, Credit::class],
            'lump two debits' => [-10, -50, -60, Debit::class],
            'lump a credit with a larger debit' => [10, -50, -40, Debit::class],
            'lump a debit with a larger credit' => [-10, 50, 40, Credit::class],
            'lump two zero amounts (considered a Credit by convention)' => [0, 0, 0, Credit::class]
        ];
    }
}
