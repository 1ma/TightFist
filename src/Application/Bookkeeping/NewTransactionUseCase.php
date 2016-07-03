<?php

declare (strict_types = 1);

namespace UMA\TightFist\Application\Budgeting;

use UMA\TightFist\Domain\Model\AccountRepository;
use UMA\DDD\Foundation\UUID;

class NewTransactionUseCase
{
    /**
     * @var AccountRepository
     */
    private $repository;

    public function __construct(AccountRepository $repository)
    {
        $this->repository = $repository;
    }

    public function execute(UUID $accountId, int $amount, string $shortMemo = null): UUID
    {
        if (null === $account = $this->repository->find($accountId)) {
            throw new \RuntimeException(); // TODO
        }

        return $account->makeTransaction($amount, $shortMemo)->getId();
    }
}
