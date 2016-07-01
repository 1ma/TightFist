<?php

declare (strict_types = 1);

namespace UMA\TightFist\Application;

use UMA\TightFist\Domain\Model\Bookkeeping\Account;
use UMA\TightFist\Domain\Model\Bookkeeping\AccountCreated;
use UMA\TightFist\Domain\Model\Bookkeeping\AccountRepository;
use UMA\TightFist\Domain\Model\Budgeting\BudgetRepository;
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

    public function execute(UUID $budgetId = null)
    {
        $account = new Account();

        if (null !== $budgetId) {
            try {
                $budget = $this->budgetRepository->get($budgetId);
            } catch (\RuntimeException $e) {
                return; // TODO
            }

            $account->joinBudget($budget);
        }

        $this->accountRepository->save($account);

        $this->dispatcher
            ->dispatch(new AccountCreated($account->getId()));
    }
}
