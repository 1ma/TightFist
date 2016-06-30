<?php

namespace UMA\TightFist\SharedKernel\EventDispatcher;

interface EventDispatcher
{

    /**
     * @param EventSubscriber $subscriber
     */
    public function addSubscriber(EventSubscriber $subscriber): EventDispatcher;

    /**
     * @param Event $event
     */
    public function dispatch(Event $event);
}
