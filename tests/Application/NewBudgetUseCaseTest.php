<?php

declare (strict_types = 1);

namespace UMA\Tests\TightFist\Application;

use UMA\Tests\TightFist\Stubs\ArrayBudgetRepository;
use UMA\Tests\TightFist\Stubs\SpySubscriber;
use UMA\TightFist\Application\NewBudgetUseCase;
use UMA\DDD\EventDispatcher\LocalEventDispatcher;

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
        $eventDispatcher = new LocalEventDispatcher();
        $eventDispatcher->addSubscriber($this->spy = new SpySubscriber());

        $this->useCase = new NewBudgetUseCase($eventDispatcher, $this->repository = new ArrayBudgetRepository());
    }

    /**
     * @test
     */
    public function kek()
    {
        $this->useCase->execute();

        $this->assertCount(1, $this->repository->getAll());
    }
}
