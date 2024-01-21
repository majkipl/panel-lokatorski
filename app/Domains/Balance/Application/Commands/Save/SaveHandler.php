<?php

namespace App\Domains\Balance\Application\Commands\Save;

use App\Domains\Balance\Domain\Repositories\BalanceRepositoryInterface;

class SaveHandler
{
    /**
     * @param BalanceRepositoryInterface $repository
     */
    public function __construct(protected BalanceRepositoryInterface $repository)
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
