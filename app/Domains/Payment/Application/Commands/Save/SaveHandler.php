<?php

namespace App\Domains\Payment\Application\Commands\Save;

use App\Domains\Payment\Domain\Repositories\PaymentRepositoryInterface;

class SaveHandler
{
    /**
     * @param PaymentRepositoryInterface $repository
     */
    public function __construct(protected PaymentRepositoryInterface $repository)
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
