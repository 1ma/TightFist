<?php

namespace UMA\TightFist\Domain\Model\Bookkeeping;

use UMA\TightFist\SharedKernel\Domain\UUID;

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
