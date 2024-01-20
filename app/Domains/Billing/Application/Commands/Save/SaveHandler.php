<?php

namespace App\Domains\Billing\Application\Commands\Save;

use App\Domains\Billing\Domain\Repositories\BillingRepositoryInterface;

class SaveHandler
{
    /**
     * @param BillingRepositoryInterface $repository
     */
    public function __construct(protected BillingRepositoryInterface $repository)
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
