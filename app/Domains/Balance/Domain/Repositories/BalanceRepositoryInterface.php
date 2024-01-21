<?php

namespace App\Domains\Balance\Domain\Repositories;

use App\Domains\Balance\Domain\Models\Balance;

interface BalanceRepositoryInterface
{

    /**
     * @param string $uuid
     * @return Balance|null
     */
    public function getLatestByAccountUuid(string $uuid): Balance|null;

    /**
     * @param string $uuid
     * @param string $projection
     * @return bool
     */
    public function updateProjection(string $uuid, string $projection): bool;

    /**
     * @param string $uuid
     * @param string $projection
     * @return bool
     */
    public function save(string $uuid, string $projection): bool;
}
