<?php

namespace App\Domains\Billing\Infrastructure\Repositories;

use App\Domains\Billing\Domain\Models\Billing;
use App\Domains\Billing\Domain\Repositories\BillingRepositoryInterface;

class BillingRepository implements BillingRepositoryInterface
{
    /**
     * @param Billing $model
     */
    public function __construct(protected Billing $model)
    {
    }

    /**
     * @param string $uuid
     * @return Billing|null
     */
    public function getLatestByAccountUuid(string $uuid): Billing|null
    {
        return $this->model->where('account_uuid', $uuid)->latest()->first();
    }

    /**
     * @param string $uuid
     * @param string $projection
     * @return bool
     */
    public function updateProjection(string $uuid, string $projection): bool
    {
        $model = $this->model->where('account_uuid', $uuid)->latest()->first();
        $model->projection = $projection;
        return $model->save();
    }

    /**
     * @param string $uuid
     * @param string $projection
     * @return bool
     */
    public function save(string $uuid, string $projection): bool
    {
        $this->model->account_uuid = $uuid;
        $this->model->projection = $projection;
        return $this->model->save();
    }
}
