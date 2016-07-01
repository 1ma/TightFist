<?php

declare (strict_types = 1);

namespace UMA\TightFist\Domain\Model\Bookkeeping;

use UMA\DDD\Foundation\UUID;

interface AccountRepository
{
    public function save(Account $account);

    /**
     * @param UUID $id
     *
     * @return Account
     *
     * @throws \RuntimeException
     */
    public function get(UUID $id): Account;
}
