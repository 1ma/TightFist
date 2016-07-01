<?php

declare (strict_types = 1);

namespace UMA\TightFist\Application;

use UMA\TightFist\Domain\Model\Bookkeeping\AccountRepository;
use UMA\TightFist\Domain\Model\Bookkeeping\TransactionCreated;
use UMA\DDD\Foundation\UUID;
use UMA\DDD\EventDispatcher\EventDispatcher;

class NewTransactionUseCase
{
    /**
     * @var EventDispatcher
     */
    private $dispatcher;

    /**
     * @var AccountRepository
     */
    private $repository;

    public function __construct(EventDispatcher $dispatcher, AccountRepository $repository)
    {
        $this->dispatcher = $dispatcher;
        $this->repository = $repository;
    }

    public function execute(UUID $accountId, int $amount, string $shortMemo = null)
    {
        try {
            $account = $this->repository->get($accountId);
        } catch (\RuntimeException $e) {
            return; // TODO
        }

        $newTransaction = $account->makeTransaction($amount, $shortMemo);

        $this->dispatcher
            ->dispatch(new TransactionCreated($newTransaction->getId()));
    }
}
