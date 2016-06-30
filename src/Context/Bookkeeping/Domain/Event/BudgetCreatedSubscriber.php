<?php

namespace UMA\TightFist\Context\Bookkeeping\Domain\Event;

use UMA\TightFist\Context\Bookkeeping\Domain\Model\Budget\BudgetId;
use UMA\TightFist\Context\Bookkeeping\Domain\Model\Budget\BudgetIdRepository;
use UMA\TightFist\Context\Budgeting\Domain\Model\Budget\BudgetCreated;
use UMA\TightFist\SharedKernel\EventDispatcher\Event;
use UMA\TightFist\SharedKernel\EventDispatcher\EventSubscriber;

class BudgetCreatedSubscriber implements EventSubscriber
{
    /**
     * @var BudgetIdRepository
     */
    private $repository;

    /**
     * @param BudgetIdRepository $repository
     */
    public function __construct(BudgetIdRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * {@inheritdoc}
     */
    public function isSubscribedTo(Event $event): bool
    {
        return $event instanceof BudgetCreated;
    }

    /**
     * {@inheritdoc}
     */
    public function handle(Event $event)
    {
        $this->repository->save(new BudgetId((string) $event));
    }
}
