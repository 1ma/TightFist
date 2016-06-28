<?php

namespace UMA\TightFist\Context\Bookkeeping\Domain;

use Ramsey\Uuid\Uuid;
use UMA\TightFist\Component\EventDispatcher\EventDispatcher;

class Account
{
    /**
     * @var string
     */
    private $id;

    /**
     * @var Transaction[]
     */
    private $transactions;

    public function __construct()
    {
        $this->id = Uuid::uuid4()->toString();
        $this->transactions = [];

        EventDispatcher::getInstance()->dispatch(
            new AccountCreated($this->id)
        );
    }

    /**
     * @param int         $amount
     * @param string|null $shortMemo
     *
     * @return Transaction
     */
    public function createTransaction(int $amount, string $shortMemo = null)
    {
        $transaction = new Transaction($this, $amount, $shortMemo);

        $this->transactions[] = $transaction;

        return $transaction;
    }
}
