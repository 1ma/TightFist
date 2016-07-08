<?php

declare (strict_types = 1);

namespace UMA\TightFist\Money;

use UMA\DDD\Foundation\ValueObject;

abstract class Money implements ValueObject
{
    /**
     * @var int
     */
    private $amount;

    public function __construct(int $amount)
    {
        $this->amount = $amount;
    }

    /**
     * @example Money::make(100) -> Credit(100)
     * @example Money::make(-50) -> Debit(50)
     */
    public static function make(int $amount)
    {
        return 0 <= $amount ?
            new Credit($amount) : new Debit($amount);
    }

    /**
     * @example Credit(100)->mirror() -> Debit(100)
     */
    public function mirror(): Money
    {
        return self::make(-1 * $this->amount);
    }

    /**
     * @example Credit(50)->lump(Debit(75)) -> Debit(25)
     */
    public function lump(Money $money): Money
    {
        return self::make($this->amount + $money->amount);
    }
}
