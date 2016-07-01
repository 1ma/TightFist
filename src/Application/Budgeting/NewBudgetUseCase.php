<?php

declare (strict_types = 1);

namespace UMA\TightFist\Application\Budgeting;

use UMA\DDD\Foundation\UUID;
use UMA\TightFist\Domain\Budgeting\Budget;
use UMA\TightFist\Domain\Budgeting\BudgetCreated;
use UMA\TightFist\Domain\Budgeting\BudgetRepository;
use UMA\DDD\EventDispatcher\EventDispatcher;

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

    public function execute(): UUID
    {
        $this->repository->save($budget = new Budget());

        $this->dispatcher
            ->dispatch(new BudgetCreated($uuid = $budget->getId()));

        return $uuid;
    }
}
