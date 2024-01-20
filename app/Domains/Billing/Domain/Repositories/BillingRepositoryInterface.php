<?php

namespace App\Domains\Billing\Domain\Repositories;

use App\Domains\Billing\Domain\Models\Billing;

interface BillingRepositoryInterface
{
    /**
     * @param string $uuid
     * @return Billing|null
     */
    public function getLatestByAccountUuid(string $uuid): Billing|null;

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
