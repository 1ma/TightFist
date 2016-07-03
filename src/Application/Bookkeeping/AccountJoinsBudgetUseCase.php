<?php

namespace UMA\TightFist\Application\Bookkeeping;

use UMA\DDD\Foundation\UUID;
use UMA\TightFist\Domain\Bookkeeping\AccountRepository;
use UMA\TightFist\Domain\Budgeting\BudgetRepository;

class AccountJoinsBudgetUseCase
{
    /**
     * @var AccountRepository
     */
    private $accountRepository;

    /**
     * @var BudgetRepository
     */
    private $budgetRepository;

    public function __construct(AccountRepository $accountRepository, BudgetRepository $budgetRepository)
    {
        $this->accountRepository = $accountRepository;
        $this->budgetRepository = $budgetRepository;
    }

    public function execute(UUID $accountId, UUID $budgetId)
    {
        if (null === $account = $this->accountRepository->find($accountId)) {
            throw new \RuntimeException();
        }

        if (null === $budget = $this->budgetRepository->find($budgetId)) {
            throw new \RuntimeException();
        }

        $this->accountRepository->save(
            $account->joinBudget($budget)
        );
    }
}
