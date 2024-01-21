<?php

namespace App\Domains\Balance\Application\Commands\UpdateProjection;

use App\Domains\Balance\Domain\Repositories\BalanceRepositoryInterface;

class UpdateProjectionHandler
{
    /**
     * @param BalanceRepositoryInterface $repository
     */
    public function __construct(protected BalanceRepositoryInterface $repository)
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
