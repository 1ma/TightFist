<?php

declare (strict_types = 1);

namespace UMA\Tests\TightFist\Budgeting;

use UMA\TightFist\Budgeting\Budget;
use UMA\TightFist\Money\Credit;
use UMA\TightFist\Money\Debit;
use UMA\TightFist\Money\Money;

class BudgetTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function basicBudgetingFlow()
    {
        $unassigned = $this->ansenyamu(Budget::class, 'unassigned');
        $categories = $this->ansenyamu(Budget::class, 'categories');
        $amount = $this->ansenyamu(Money::class, 'amount');

        $budget = (new Budget())
            ->createCategory('food')
            ->createCategory('rent')
            ->earn(new Credit(1000))
            ->assign('food', new Credit(350))
            ->assign('rent', new Credit(550))
            ->spend('food', new Debit(-25))
            ->spend('food', new Debit(-5))
            ->spend('rent', new Debit(-500))
            ->spend('food', new Debit(-10));

        $leftUnassigned = $amount->getValue($unassigned->getValue($budget));
        $leftForFood = $amount->getValue($categories->getValue($budget)->get('food')->getCurrentBalance());
        $leftForRent = $amount->getValue($categories->getValue($budget)->get('rent')->getCurrentBalance());

        $this->assertSame(100, $leftUnassigned);
        $this->assertSame(310, $leftForFood);
        $this->assertSame(50, $leftForRent);
    }

    private function ansenyamu(string $class, string $property): \ReflectionProperty
    {
        $property = new \ReflectionProperty($class, $property);
        $property->setAccessible(true);

        return $property;
    }
}
