<?php

declare (strict_types = 1);

namespace UMA\Tests\TightFist\Stubs;

use UMA\DDD\EventDispatcher\Event;
use UMA\DDD\EventDispatcher\EventSubscriber;

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
