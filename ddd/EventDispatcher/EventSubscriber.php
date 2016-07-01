<?php

declare (strict_types = 1);

namespace UMA\DDD\EventDispatcher;

interface EventSubscriber
{
    /**
     * @param Event $event
     *
     * @return bool
     */
    public function isSubscribedTo(Event $event): bool;

    /**
     * @param Event $event
     */
    public function handle(Event $event);
}
