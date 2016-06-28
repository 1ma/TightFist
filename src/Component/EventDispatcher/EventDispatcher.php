<?php

namespace UMA\TightFist\Component\EventDispatcher;

class EventDispatcher
{
    /**
     * @var EventDispatcher
     */
    private static $instance = null;

    /**
     * @var EventSubscriberInterface[]
     */
    private $subscribers;

    /**
     * @return EventDispatcher
     */
    public static function getInstance()
    {
        if (null === self::$instance) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    /**
     * @param EventSubscriberInterface $subscriber
     */
    public function addSubscriber(EventSubscriberInterface $subscriber)
    {
        if (isset($this->subscribers[get_class($subscriber)])) {
            throw new \LogicException('fuck you, you cannot add two instances of the same subscriber class');
        }

        $this->subscribers[get_class($subscriber)] = $subscriber;
    }

    /**
     * @param EventInterface $event
     */
    public function dispatch(EventInterface $event)
    {
        foreach ($this->subscribers as $subscriber) {
            $subscriptions = $subscriber->getSubscribedEvents();
            if (in_array(get_class($event), $subscriptions)) {
                $subscriber->handle($event);
            }
        }
    }

    private function __construct()
    {
        $this->subscribers = [];
    }
}
