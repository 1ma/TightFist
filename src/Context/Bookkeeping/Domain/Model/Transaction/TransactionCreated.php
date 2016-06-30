<?php

namespace UMA\TightFist\Context\Bookkeeping\Domain\Model\Transaction;

use UMA\TightFist\SharedKernel\EventDispatcher\Event;

class TransactionCreated implements Event
{
    /**
     * @var string
     */
    private $id;

    /**
     * @var int
     */
    private $amount;

    /**
     * @var \DateTime
     */
    private $occurredAt;

    /**
     * @param string    $id
     * @param int       $amount
     */
    public function __construct(string $id, int $amount)
    {
        $this->id = $id;
        $this->amount = $amount;
        $this->occurredAt = new \DateTime('now');
    }

    public function __toString()
    {
        return json_encode('');
    }

    public function occurredAt(): \DateTime
    {
        return $this->occurredAt;
    }
}
