<?php

declare (strict_types = 1);

namespace UMA\TightFist\Domain\Model\Budgeting;

use UMA\DDD\Foundation\UUID;

interface BudgetRepository
{
    public function exists(UUID $id): bool;

    public function save(Budget $budget);

    /**
     * @param UUID $id
     *
     * @return Budget
     *
     * @throws \RuntimeException
     */
    public function get(UUID $id): Budget;
}
