<?php

namespace App\Domains\Expense\Application\Commands\UpdateProjection;

use App\Domains\Expense\Domain\Repositories\ExpenseRepositoryInterface;

class UpdateProjectionHandler
{
    /**
     * @param ExpenseRepositoryInterface $repository
     */
    public function __construct(protected ExpenseRepositoryInterface $repository)
    {
    }

    /**
     * @param UpdateProjectionCommand $command
     * @return bool
     */
    public function handle(UpdateProjectionCommand $command): bool
    {
        return $this->repository->updateProjection(
            uuid: $command->getUuid(),
            projection: $command->getProjection()
        );
    }
}
