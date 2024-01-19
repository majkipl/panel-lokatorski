<?php

namespace App\Domains\Expense\Application\Queries\FindLatestExpenseByAccountUuid;

use App\Domains\Expense\Domain\Repositories\ExpenseRepositoryInterface;

class FindLatestExpenseByAccountUuidHandler
{
    /**
     * @param ExpenseRepositoryInterface $repository
     */
    public function __construct(protected ExpenseRepositoryInterface $repository)
    {
    }


    /**
     * @param FindLatestExpenseByAccountUuidQuery $query
     * @return string
     */
    public function handle(FindLatestExpenseByAccountUuidQuery $query): string
    {
        return $this->repository->getLatestByAccountUuid($query->getUuid())->projection ?? serialize([]);
    }
}
