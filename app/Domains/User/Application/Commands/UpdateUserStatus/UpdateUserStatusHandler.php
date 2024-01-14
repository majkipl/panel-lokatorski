<?php

namespace App\Domains\User\Application\Commands\UpdateUserStatus;

use App\Domains\User\Domain\Repositories\UserRepositoryInterface;

class UpdateUserStatusHandler
{
    /**
     * @param UserRepositoryInterface $repository
     */
    public function __construct(protected UserRepositoryInterface $repository)
    {
    }

    /**
     * @param UpdateUserStatusCommand $command
     * @return bool
     */
    public function handle(UpdateUserStatusCommand $command): bool
    {
        return $this->repository->updateStatus(
            id: $command->getId(),
            status: $command->getStatus()
        );
    }
}
