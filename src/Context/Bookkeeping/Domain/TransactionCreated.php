<?php

namespace UMA\TightFist\Context\Bookkeeping\Domain;

use UMA\TightFist\Component\EventDispatcher\EventInterface;

class TransactionCreated implements EventInterface
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
    private $createdAt;

    /**
     * @param string    $id
     * @param int       $amount
     * @param \DateTime $createdAt
     */
    public function __construct(string $id, int $amount, \DateTime $createdAt)
    {
        $this->id = $id;
        $this->amount = $amount;
        $this->createdAt = $createdAt;
    }
}
