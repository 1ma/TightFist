<?php

declare(strict_types = 1);

namespace UMA\TightFist\SharedKernel\EventDispatcher;

class LocalEventDispatcher implements EventDispatcher
{
    /**
     * @var EventSubscriber[]
     */
    private $subscribers = [];

    /**
     * @param EventSubscriber $subscriber
     */
    public function addSubscriber(EventSubscriber $subscriber): EventDispatcher
    {
        $this->subscribers[] = $subscriber;

        return $this;
    }

    /**
     * @param Event $event
     */
    public function dispatch(Event $event)
    {
        foreach ($this->subscribers as $subscriber) {
            if ($subscriber->isSubscribedTo($event)) {
                $subscriber->handle($event);
            }
        }
    }
}
