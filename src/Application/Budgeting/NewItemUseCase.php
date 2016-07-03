<?php

declare (strict_types = 1);

namespace UMA\TightFist\Application\Budgeting;

use UMA\TightFist\Domain\Model\Budgeting\BudgetRepository;
use UMA\DDD\Foundation\UUID;
use UMA\DDD\EventDispatcher\EventDispatcher;

class NewItemUseCase
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

    public function execute(UUID $budgetId, string $itemName)
    {
        try {
            $budget = $this->repository->get($budgetId);
        } catch (\RuntimeException $e) {
            return; // TODO
        }

        $budget->addItem($itemName);
    }
}
