<?php

namespace UMA\TightFist\Context\Bookkeeping\Domain;

use Ramsey\Uuid\Uuid;
use UMA\TightFist\Component\EventDispatcher\EventDispatcher;

class Transaction
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

    /**
     * @var \DateTime
     */
    private $createdAt;

    /**
     * @param Account     $account
     * @param int         $amount
     * @param string|null $shortMemo
     */
    public function __construct(Account $account, int $amount, string $shortMemo = null)
    {
        $this->id = Uuid::uuid4()->toString();
        $this->account = $account;
        $this->amount = $amount;
        $this->shortMemo = $shortMemo;
        $this->createdAt = new \DateTime('now');

        EventDispatcher::getInstance()->dispatch(
            new TransactionCreated($this->id, $this->amount, $this->createdAt)
        );
    }
}
