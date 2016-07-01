<?php

declare(strict_types = 1);

namespace UMA\Tests\TightFist\Stubs;

use UMA\TightFist\Domain\Model\Budgeting\Budget;
use UMA\TightFist\Domain\Model\Budgeting\BudgetRepository;
use UMA\TightFist\SharedKernel\Domain\UUID;

class ArrayBudgetRepository implements BudgetRepository
{
    /**
     * @var Budget[]
     */
    private $entities = [];

    public function exists(UUID $id): bool
    {
        return isset($this->entities[(string) $id]);
    }

    public function save(Budget $budget)
    {
        $this->entities[(string) $budget->getId()] = $budget;
    }

    /**
     * @param UUID $id
     *
     * @return Budget
     *
     * @throws \RuntimeException
     */
    public function get(UUID $id): Budget
    {
        if (isset($this->entities[(string) $id])) {
            throw new \RuntimeException;
        }

        return $this->entities[(string) $id];
    }

    /**
     * @return Budget[]
     */
    public function getAll()
    {
        return $this->entities;
    }
}
