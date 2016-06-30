<?php

namespace UMA\Tests\TightFist\Stubs;

use UMA\TightFist\SharedKernel\EventDispatcher\Event;
use UMA\TightFist\SharedKernel\EventDispatcher\EventSubscriber;

class SpySubscriber implements EventSubscriber
{
    /**
     * @var Event[]
     */
    private $observedEvents = [];

    /**
     * @param Event $event
     *
     * @return bool
     */
    public function isSubscribedTo(Event $event): bool
    {
        return true;
    }

    /**
     * @param Event $event
     */
    public function handle(Event $event)
    {
        $this->observedEvents[] = $event;
    }

    public function getObservedEvents()
    {
        return $this->observedEvents;
    }
}
