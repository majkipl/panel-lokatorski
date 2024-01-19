<?php

namespace App\Domains\Expense\Application\Queries\FindAllByAccountUuid;

use App\Domains\Expense\Domain\Repositories\ExpenseRepositoryInterface;

class FindAllByAccountUuidHandler
{
    /**
     * @param ExpenseRepositoryInterface $repository
     */
    public function __construct(protected ExpenseRepositoryInterface $repository)
    {
    }

    /**
     * @param FindAllByAccountUuidQuery $query
     * @return array
     */
    public function handle(FindAllByAccountUuidQuery $query): array
    {
        $model = $this->repository->getLatestByAccountUuid($query->getUuid())->projection ?? serialize([]);

        $expenses = unserialize($model);

        usort($expenses, function ($a, $b) {
            return $b['created_at'] <=> $a['created_at'];
        });

        return $expenses;
    }
}
