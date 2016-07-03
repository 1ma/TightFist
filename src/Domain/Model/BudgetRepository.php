<?php

declare (strict_types = 1);

namespace UMA\TightFist\Domain\Model;

use UMA\DDD\Foundation\UUID;

interface BudgetRepository
{
    /**
     * @param UUID $id
     *
     * @return Budget|null
     */
    public function find(UUID $id);

    /**
     * @param UUID $id
     *
     * @return Budget
     *
     * @throws \RuntimeException
     */
    public function get(UUID $id): Budget;

    public function save(Budget $budget);
}
