<?php

namespace App\Domains\Expense\Application\Commands\Save;

use App\Domains\Expense\Domain\Repositories\ExpenseRepositoryInterface;

class SaveHandler
{
    /**
     * @param ExpenseRepositoryInterface $repository
     */
    public function __construct(protected ExpenseRepositoryInterface $repository)
    {
    }

    /**
     * @param SaveCommand $command
     * @return bool
     */
    public function handle(SaveCommand $command): bool
    {
        return $this->repository->save(
            uuid: $command->getUuid(),
            projection: $command->getProjection()
        );
    }
}
