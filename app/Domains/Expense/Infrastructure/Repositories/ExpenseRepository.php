<?php

namespace App\Domains\Expense\Infrastructure\Repositories;

use App\Domains\Expense\Domain\Models\Expense;
use App\Domains\Expense\Domain\Repositories\ExpenseRepositoryInterface;

class ExpenseRepository implements ExpenseRepositoryInterface
{
    /**
     * @param Expense $model
     */
    public function __construct(protected Expense $model)
    {
    }

    /**
     * @param string $uuid
     * @return Expense|null
     */
    public function getLatestByAccountUuid(string $uuid): Expense|null
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
