<?php

declare (strict_types = 1);

namespace UMA\Tests\TightFist\Stubs;

use UMA\TightFist\Domain\Budgeting\Budget;
use UMA\TightFist\Domain\Budgeting\BudgetRepository;
use UMA\DDD\Foundation\UUID;

class ArrayBudgetRepository implements BudgetRepository
{
    /**
     * @var Budget[]
     */
    private $entities = [];

    /**
     * {@inheritdoc}
     */
    public function find(UUID $id)
    {
        return $this->entities[(string) $id] ?? null;
    }

    /**
     * {@inheritdoc}
     */
    public function get(UUID $id): Budget
    {
        if (!isset($this->entities[(string) $id])) {
            throw new \RuntimeException();
        }

        return $this->entities[(string) $id];
    }

    public function save(Budget $budget)
    {
        $this->entities[(string) $budget->getId()] = $budget;
    }

    /**
     * @return Budget[]
     */
    public function getAll()
    {
        return array_values($this->entities);
    }
}
