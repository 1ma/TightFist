<?php

declare (strict_types = 1);

namespace UMA\TightFist\Application\Budgeting;

use UMA\TightFist\Domain\Bookkeeping\Account;
use UMA\TightFist\Domain\Bookkeeping\AccountCreated;
use UMA\TightFist\Domain\Bookkeeping\AccountRepository;
use UMA\TightFist\Domain\Budgeting\BudgetRepository;
use UMA\DDD\Foundation\UUID;
use UMA\DDD\EventDispatcher\EventDispatcher;

class NewAccountUseCase
{
    /**
     * @var EventDispatcher
     */
    private $dispatcher;

    /**
     * @var AccountRepository
     */
    private $accountRepository;

    /**
     * @var BudgetRepository
     */
    private $budgetRepository;

    public function __construct(EventDispatcher $dispatcher, AccountRepository $accountRepository, BudgetRepository $budgetRepository)
    {
        $this->dispatcher = $dispatcher;
        $this->accountRepository = $accountRepository;
        $this->budgetRepository = $budgetRepository;
    }

    public function execute(UUID $budgetId = null): UUID
    {
        $account = new Account();

        if (null !== $budgetId) {
            if (null === $budget = $this->budgetRepository->find($budgetId))  {
                return; //TODO
            }

            $account->joinBudget($budget);
        }

        $this->accountRepository->save($account);

        $this->dispatcher
            ->dispatch(new AccountCreated($accountId = $account->getId()));

        return $accountId;
    }
}
