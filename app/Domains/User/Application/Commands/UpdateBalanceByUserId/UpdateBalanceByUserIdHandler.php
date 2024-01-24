<?php

namespace App\Domains\User\Application\Commands\UpdateBalanceByUserId;

use App\Domains\User\Domain\Repositories\AccountRepositoryInterface;

class UpdateBalanceByUserIdHandler
{
    /**
     * @param AccountRepositoryInterface $repository
     */
    public function __construct(protected AccountRepositoryInterface $repository)
    {
    }

    /**
     * @param UpdateBalanceByUserIdCommand $command
     * @return bool
     */
    public function handle(UpdateBalanceByUserIdCommand $command): bool
    {
        return $this->repository->updateBalanceByUserId(
            id: $command->getId(),
            balance: $command->getBalance()
        );
    }
}
