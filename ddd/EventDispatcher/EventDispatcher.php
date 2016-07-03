<?php

declare (strict_types = 1);

namespace UMA\DDD\EventDispatcher;

interface EventDispatcher
{
    /**
     * @param EventSubscriber $subscriber
     */
    public function addSubscriber(EventSubscriber $subscriber);

    /**
     * @param Event $event
     */
    public function dispatch(Event $event);
}
