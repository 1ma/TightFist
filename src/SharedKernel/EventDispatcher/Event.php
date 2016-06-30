<?php

namespace UMA\TightFist\SharedKernel\EventDispatcher;

interface Event
{
    public function occurredAt(): \DateTime;

    public function __toString();
}
