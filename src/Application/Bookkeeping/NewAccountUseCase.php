<?php

declare (strict_types = 1);

namespace UMA\TightFist\Application\Budgeting;

use UMA\DDD\Foundation\UUID;
use UMA\TightFist\Domain\Model\Account;
use UMA\TightFist\Domain\Model\AccountRepository;

class NewAccountUseCase
{
    /**
     * @var AccountRepository
     */
    private $repository;

    public function __construct(AccountRepository $repository)
    {
        $this->repository = $repository;
    }

    public function execute(): UUID
    {
        $this->repository->save($account = new Account());

        return $account->getId();
    }
}
