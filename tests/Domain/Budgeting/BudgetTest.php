<?php

declare (strict_types = 1);

namespace UMA\Tests\TightFist\Domain\Budgeting;

use UMA\TightFist\Domain\Budgeting\Budget;

class BudgetTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function testBrainstormingScenario()
    {
        $budget = new Budget();
        $this->assertSame(0, $budget->getIdleBalance());

        $budget->earn(11023);
        $this->assertSame(11023, $budget->getIdleBalance());

        $budget->addItem('food')->allocate('food', 10000);
        $this->assertSame(1023, $budget->getIdleBalance());
        $this->assertSame(10000, $budget->getItemBalance('food'));

        $budget->spend('food', 2500);
        $this->assertSame(1023, $budget->getIdleBalance());
        $this->assertSame(7500, $budget->getItemBalance('food'));

        $budget->discardItem('food');
        $this->assertSame(8523, $budget->getIdleBalance());
    }
}
