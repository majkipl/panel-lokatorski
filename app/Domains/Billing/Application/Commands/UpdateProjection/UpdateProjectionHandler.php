<?php

namespace App\Domains\Billing\Application\Commands\UpdateProjection;

use App\Domains\Billing\Domain\Repositories\BillingRepositoryInterface;

class UpdateProjectionHandler
{
    /**
     * @param BillingRepositoryInterface $repository
     */
    public function __construct(protected BillingRepositoryInterface $repository)
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
