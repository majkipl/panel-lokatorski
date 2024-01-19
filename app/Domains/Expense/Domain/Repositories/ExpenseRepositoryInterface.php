<?php

namespace App\Domains\Expense\Domain\Repositories;

use App\Domains\Expense\Domain\Models\Expense;

interface ExpenseRepositoryInterface
{
    /**
     * @param string $uuid
     * @return Expense|null
     */
    public function getLatestByAccountUuid(string $uuid): Expense|null;

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
