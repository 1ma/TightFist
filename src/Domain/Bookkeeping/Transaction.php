<?php

declare (strict_types = 1);

namespace UMA\TightFist\Domain\Bookkeeping;

use UMA\DDD\Foundation\Entity;
use UMA\DDD\Foundation\UUID;

class Transaction implements Entity
{
    /**
     * @var string
     */
    private $id;

    /**
     * @var Account
     */
    private $account;

    /**
     * @var int
     */
    private $amount;

    /**
     * @var string
     */
    private $shortMemo;

    public function __construct(Account $account, int $amount, string $shortMemo = null)
    {
        $this->id = new UUID();
        $this->account = $account;
        $this->amount = $amount;
        $this->shortMemo = $shortMemo;
    }

    public function getId(): UUID
    {
        return $this->id;
    }

    public function getAmount(): int
    {
        return $this->amount;
    }
}
