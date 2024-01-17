<?php

namespace App\Domains\Payment\Domain\Repositories;

use App\Domains\Payment\Domain\Models\Payment;
use Illuminate\Support\Collection;

interface PaymentRepositoryInterface
{
    /**
     * @param string $uuid
     * @return Payment|null
     */
    public function getLatestByAccountUuid(string $uuid): Payment|null;

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

    /**
     * @return Collection
     */
    public function getLatest(): Collection;
}
