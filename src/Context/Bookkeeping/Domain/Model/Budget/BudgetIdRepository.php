<?php

namespace UMA\TightFist\Context\Bookkeeping\Domain\Model\Budget;

interface BudgetIdRepository
{
    public function exists(string $id): bool;

    public function save(BudgetId $id);

    public function remove(BudgetId $id);
}
