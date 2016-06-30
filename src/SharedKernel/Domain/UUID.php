<?php

namespace UMA\TightFist\SharedKernel\Domain;

use Ramsey\Uuid\Uuid as Generator;

class UUID implements ValueObject
{
    /**
     * @var string
     */
    private $uuid;

    public function __construct()
    {
        $this->uuid = Generator::uuid4()->toString();
    }

    public function __toString()
    {
        return $this->uuid;
    }

    public function equals(ValueObject $object): bool
    {
        return $object instanceof UUID
            && (string) $object === (string) $this;
    }
}
