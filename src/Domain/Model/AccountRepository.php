<?php

declare (strict_types = 1);

namespace UMA\TightFist\Domain\Model;

use UMA\DDD\Foundation\UUID;

interface AccountRepository
{
    /**
     * @param UUID $id
     *
     * @return Account|null
     */
    public function find(UUID $id);

    /**
     * @param UUID $id
     *
     * @return Account
     *
     * @throws \RuntimeException
     */
    public function get(UUID $id): Account;

    public function save(Account $account);
}
