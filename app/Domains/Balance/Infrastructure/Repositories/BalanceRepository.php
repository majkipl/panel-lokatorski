<?php

namespace App\Domains\Balance\Infrastructure\Repositories;

use App\Domains\Balance\Domain\Models\Balance;
use App\Domains\Balance\Domain\Repositories\BalanceRepositoryInterface;

class BalanceRepository implements BalanceRepositoryInterface
{
    /**
     * @param Balance $model
     */
    public function __construct(protected Balance $model)
    {
    }

    /**
     * @param string $uuid
     * @return Balance|null
     */
    public function getLatestByAccountUuid(string $uuid): Balance|null
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
