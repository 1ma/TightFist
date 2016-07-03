<?php

declare (strict_types = 1);

namespace UMA\DDD\EventDispatcher;

class GenericEventDispatcher implements EventDispatcher
{
    /**
     * @var EventSubscriber[]
     */
    private $subscribers = [];

    /**
     * {@inheritdoc}
     *
     * @return GenericEventDispatcher
     */
    public function addSubscriber(EventSubscriber $subscriber): EventDispatcher
    {
        $this->subscribers[] = $subscriber;

        return $this;
    }

    /**
     * {@inheritdoc}
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
