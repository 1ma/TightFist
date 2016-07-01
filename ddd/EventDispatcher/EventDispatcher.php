<?php

declare (strict_types = 1);

namespace UMA\DDD\EventDispatcher;

interface EventDispatcher
{
    /**
     * @param EventSubscriber $subscriber
     *
     * @return EventDispatcher
     */
    public function addSubscriber(EventSubscriber $subscriber): EventDispatcher;

    /**
     * @param Event $event
     */
    public function dispatch(Event $event);
}
