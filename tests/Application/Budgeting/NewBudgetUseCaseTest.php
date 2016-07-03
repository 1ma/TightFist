<?php

declare (strict_types = 1);

namespace UMA\Tests\TightFist\Application\Budgeting;

use UMA\DDD\EventDispatcher\DomainEventDispatcher;
use UMA\Tests\TightFist\Stubs\ArrayBudgetRepository;
use UMA\Tests\TightFist\Stubs\SpySubscriber;
use UMA\TightFist\Application\Budgeting\NewBudgetUseCase;
use UMA\DDD\EventDispatcher\GenericEventDispatcher;
use UMA\TightFist\Domain\Event\BudgetCreated;

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

    /**
     * {@inheritdoc}
     */
    protected function setUp()
    {
        DomainEventDispatcher::setInstance(
            (new GenericEventDispatcher())
                ->addSubscriber($this->spy = new SpySubscriber())
        );

        $this->useCase = new NewBudgetUseCase($this->repository = new ArrayBudgetRepository());
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
    public function happyPath()
    {
        $newBudgetId = $this->useCase->execute();

        $this->assertCount(1, $budgets = $this->repository->getAll());
        $this->assertEquals($newBudgetId, $budgets[0]->getId());

        $this->assertCount(1, $events = $this->spy->getObservedEvents());
        $this->assertInstanceOf(BudgetCreated::class, $events[0]);
    }
}
