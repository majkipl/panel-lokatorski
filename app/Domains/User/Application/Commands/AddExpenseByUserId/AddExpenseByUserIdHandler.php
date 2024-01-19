<?php

namespace App\Domains\User\Application\Commands\AddExpenseByUserId;

use App\Domains\User\Domain\Repositories\UserRepositoryInterface;

class AddExpenseByUserIdHandler
{
    /**
     * @param UserRepositoryInterface $repository
     */
    public function __construct(protected UserRepositoryInterface $repository)
    {
    }

    /**
     * @param AddExpenseByUserIdCommand $command
     * @return void
     */
    public function handle(AddExpenseByUserIdCommand $command): void
    {
        $this->repository->addExpense(
            id: $command->getId(),
            name: $command->getName(),
            amount: $command->getAmount(),
        );
    }
}
