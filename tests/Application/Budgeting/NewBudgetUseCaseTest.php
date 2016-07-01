<?php

declare (strict_types = 1);

namespace UMA\Tests\TightFist\Application\Budgeting;

use UMA\Tests\TightFist\Stubs\ArrayBudgetRepository;
use UMA\Tests\TightFist\Stubs\SpySubscriber;
use UMA\TightFist\Application\Budgeting\NewBudgetUseCase;
use UMA\DDD\EventDispatcher\GenericEventDispatcher;
use UMA\TightFist\Domain\Budgeting\BudgetCreated;

class NewBudgetUseCaseTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var ArrayBudgetRepository
     */
    private $repository;

    /**
     * @var SpySubscriber
     */
    private $spy;

    /**
     * @var NewBudgetUseCase
     */
    private $useCase;

    protected function setUp()
    {
        $eventDispatcher = (new GenericEventDispatcher())
            ->addSubscriber($this->spy = new SpySubscriber());

        $this->useCase = new NewBudgetUseCase($eventDispatcher, $this->repository = new ArrayBudgetRepository());
    }

    /**
     * @test
     */
    public function happyPath()
    {
        $newBudgetId = $this->useCase->execute();

        $this->assertCount(1, $budgets = $this->repository->getAll());
        $this->assertEquals($newBudgetId, $budgets[0]->getId());

        $this->assertCount(1, $events = $this->spy->getObservedEvents());
        $this->assertInstanceOf(BudgetCreated::class, $events[0]);
    }
}
