<?php

namespace UMA\TightFist\Component\EventDispatcher;

interface EventSubscriberInterface
{
    /**
     * @return string[]
     */
    public function getSubscribedEvents(): array;

    /**
     * @param EventInterface $event
     */
    public function handle(EventInterface $event);
}
