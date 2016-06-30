<?php

namespace UMA\Tests\TightFist\Context\Budgeting\Domain;

use UMA\Tests\TightFist\Stubs\SpySubscriber;
use UMA\TightFist\Context\Budgeting\Domain\Model\Budget\Budget;
use UMA\TightFist\Context\Budgeting\Domain\Model\Budget\BudgetCreated;
use UMA\TightFist\SharedKernel\EventDispatcher\LocalEventDispatcher;

class BudgetTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function testBrainstormingScenario()
    {
        $dispatcher = (new LocalEventDispatcher())
            ->addSubscriber($spy = new SpySubscriber());

        $budget = new Budget($dispatcher);
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

        $this->assertCount(1, $events = $spy->getObservedEvents());
        $this->assertInstanceOf(BudgetCreated::class, $events[0]);
    }
}
