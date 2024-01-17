<?php

namespace App\Domains\User\Application\Commands\SubtractMoneyByUserId;

use App\Domains\User\Domain\Repositories\UserRepositoryInterface;

class SubtractMoneyByUserIdHandler
{
    /**
     * @param UserRepositoryInterface $repository
     */
    public function __construct(protected UserRepositoryInterface $repository)
    {
    }

    /**
     * @param SubtractMoneyByUserIdCommand $command
     * @return void
     */
    public function handle(SubtractMoneyByUserIdCommand $command): void
    {
        $this->repository->subtractMoney(
            id: $command->getId(),
            amount: $command->getAmount(),
        );
    }
}
