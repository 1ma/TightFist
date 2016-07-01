<?php

namespace UMA\TightFist\Application;

use UMA\TightFist\Domain\Model\Budgeting\Budget;
use UMA\TightFist\Domain\Model\Budgeting\BudgetCreated;
use UMA\TightFist\Domain\Model\Budgeting\BudgetRepository;
use UMA\TightFist\SharedKernel\EventDispatcher\EventDispatcher;

class NewBudgetUseCase
{
    /**
     * @var EventDispatcher
     */
    private $dispatcher;

    /**
     * @var BudgetRepository
     */
    private $repository;

    public function __construct(EventDispatcher $dispatcher, BudgetRepository $repository)
    {
        $this->dispatcher = $dispatcher;
        $this->repository = $repository;
    }

    public function execute()
    {
        $this->repository->save($budget = new Budget());

        $this->dispatcher
            ->dispatch(new BudgetCreated($budget->getId()));
    }
}
