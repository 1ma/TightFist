<?php

declare (strict_types = 1);

namespace UMA\Tests\TightFist\Domain\Budgeting;

use UMA\DDD\EventDispatcher\DomainEventDispatcher;
use UMA\DDD\EventDispatcher\GenericEventDispatcher;
use UMA\Tests\TightFist\Stubs\SpySubscriber;
use UMA\TightFist\Domain\Budgeting\Budget;
use UMA\TightFist\Domain\Budgeting\BudgetCreated;

class BudgetTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var SpySubscriber
     */
    private $spy;

    /**
     * {@inheritdoc}
     */
    protected function setUp()
    {
        DomainEventDispatcher::setInstance(
            (new GenericEventDispatcher())
                ->addSubscriber($this->spy = new SpySubscriber())
        );
    }

    /**
     * {@inheritdoc}
     */
    protected function tearDown()
    {
        DomainEventDispatcher::clear();
    }

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

        $this->assertCount(1, $events = $this->spy->getObservedEvents());
        $this->assertInstanceOf(BudgetCreated::class, $events[0]);
    }
}
