<?php

declare (strict_types = 1);

namespace UMA\DDD\EventDispatcher;

use UMA\DDD\Foundation\ValueObject;

interface Event extends ValueObject
{
    public function occurredAt(): \DateTimeImmutable;

    public function __toString();
}
