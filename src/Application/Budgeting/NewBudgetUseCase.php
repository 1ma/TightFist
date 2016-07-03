<?php

declare (strict_types = 1);

namespace UMA\TightFist\Application\Budgeting;

use UMA\DDD\Foundation\UUID;
use UMA\TightFist\Domain\Budgeting\Budget;
use UMA\TightFist\Domain\Budgeting\BudgetRepository;

class NewBudgetUseCase
{
    /**
     * @var BudgetRepository
     */
    private $repository;

    public function __construct(BudgetRepository $repository)
    {
        $this->repository = $repository;
    }

    public function execute(): UUID
    {
        $this->repository->save($budget = new Budget());

        return $budget->getId();
    }
}
