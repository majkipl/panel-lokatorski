<?php

namespace App\Domains\User\Application\Commands\AddMoneyByUserId;

use App\Domains\User\Domain\Repositories\UserRepositoryInterface;

class AddMoneyByUserIdHandler
{
    /**
     * @param UserRepositoryInterface $repository
     */
    public function __construct(protected UserRepositoryInterface $repository)
    {
    }

    /**
     * @param AddMoneyByUserIdCommand $command
     * @return void
     */
    public function handle(AddMoneyByUserIdCommand $command): void
    {
        $this->repository->addMoney(
            id: $command->getId(),
            amount: $command->getAmount(),
        );
    }
}
