<?php

namespace App\Domains\Payment\Application\Commands\UpdateProjection;

use App\Domains\Payment\Domain\Repositories\PaymentRepositoryInterface;

class UpdateProjectionHandler
{
    /**
     * @param PaymentRepositoryInterface $repository
     */
    public function __construct(protected PaymentRepositoryInterface $repository)
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
