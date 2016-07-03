<?php

declare (strict_types = 1);

namespace UMA\DDD\Foundation;

interface Entity
{
    /**
     * @return mixed
     */
    public function getId();
}
