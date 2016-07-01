<?php

declare (strict_types = 1);

namespace UMA\DDD\Foundation;

use Ramsey\Uuid\Uuid as Generator;

class UUID implements ValueObject
{
    /**
     * @var string
     */
    private $uuid;

    public function __construct(string $uuid = null)
    {
        if (null !== $uuid && !Generator::isValid($uuid)) {
            throw new \InvalidArgumentException('haha n00b');
        }

        $this->uuid = $uuid ?? Generator::uuid4()->toString();
    }

    public function __toString()
    {
        return $this->uuid;
    }

    public function equals(ValueObject $object): bool
    {
        return $object instanceof self
            && (string) $object === (string) $this;
    }
}
