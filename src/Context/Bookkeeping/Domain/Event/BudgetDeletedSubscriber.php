<?php

namespace UMA\TightFist\Context\Bookkeeping\Domain\Event;

use UMA\TightFist\Context\Bookkeeping\Domain\Model\Budget\BudgetId;
use UMA\TightFist\Context\Bookkeeping\Domain\Model\Budget\BudgetIdRepository;
use UMA\TightFist\Context\Budgeting\Domain\Model\Budget\BudgetDeleted;
use UMA\TightFist\SharedKernel\EventDispatcher\Event;
use UMA\TightFist\SharedKernel\EventDispatcher\EventSubscriber;

class BudgetDeletedSubscriber implements EventSubscriber
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
        return $event instanceof BudgetDeleted;
    }

    /**
     * {@inheritdoc}
     */
    public function handle(Event $event)
    {
        $this->repository->remove(new BudgetId((string) $event));
    }
}
