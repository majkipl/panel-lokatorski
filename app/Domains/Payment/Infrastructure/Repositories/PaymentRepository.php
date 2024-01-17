<?php

namespace App\Domains\Payment\Infrastructure\Repositories;

use App\Domains\Payment\Domain\Models\Payment;
use App\Domains\Payment\Domain\Repositories\PaymentRepositoryInterface;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class PaymentRepository implements PaymentRepositoryInterface
{
    /**
     * Create a new class instance.
     */
    public function __construct(protected Payment $model)
    {
    }

    /**
     * @param string $uuid
     * @return Payment|null
     */
    public function getLatestByAccountUuid(string $uuid): Payment|null
    {
        return $this->model->where('account_uuid', $uuid)->latest()->first();
    }

    /**
     * @return Collection
     */
    public function getLatest(): Collection
    {
        return DB::table('payments as p1')
            ->join(DB::raw('(SELECT account_uuid, MAX(updated_at) as max_updated_at FROM payments GROUP BY account_uuid) as p2'), function ($join) {
                $join->on('p1.account_uuid', '=', 'p2.account_uuid');
                $join->on('p1.updated_at', '=', 'p2.max_updated_at');
            })
            ->select('p1.*')
            ->get();
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
