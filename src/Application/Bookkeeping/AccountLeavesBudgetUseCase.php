<?php

namespace UMA\TightFist\Application\Bookkeeping;

use UMA\DDD\Foundation\UUID;
use UMA\TightFist\Domain\Bookkeeping\AccountRepository;

class AccountLeavesBudgetUseCase
{
    /**
     * @var AccountRepository
     */
    private $repository;

    public function __construct(AccountRepository $repository)
    {
        $this->repository = $repository;
    }

    public function execute(UUID $accountId)
    {
        if (null === $account = $this->repository->find($accountId)) {
            throw new \RuntimeException();
        }

        $this->repository->save(
            $account->leaveBudget()
        );
    }
}
