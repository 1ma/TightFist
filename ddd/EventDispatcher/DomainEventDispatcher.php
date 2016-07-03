<?php

declare (strict_types = 1);

namespace UMA\DDD\EventDispatcher;

class DomainEventDispatcher
{
    /**
     * @var EventDispatcher
     */
    private static $dispatcher = null;

    public static function clear()
    {
        self::$dispatcher = null;
    }

    public static function getInstance(): EventDispatcher
    {
        if (null === self::$dispatcher) {
            throw new \LogicException('DomainEventDispatcher has not been initialized');
        }

        return self::$dispatcher;
    }

    public static function setInstance(EventDispatcher $dispatcher)
    {
        self::$dispatcher = $dispatcher;
    }
}
