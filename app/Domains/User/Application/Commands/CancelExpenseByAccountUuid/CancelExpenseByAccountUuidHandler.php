<?php

namespace App\Domains\User\Application\Commands\CancelExpenseByAccountUuid;

use App\Domains\User\Domain\Repositories\AccountRepositoryInterface;

class CancelExpenseByAccountUuidHandler
{
    /**
     * @param AccountRepositoryInterface $repository
     */
    public function __construct(protected AccountRepositoryInterface $repository)
    {
    }

    /**
     * @param CancelExpenseByAccountUuidCommand $command
     * @return void
     */
    public function handle(CancelExpenseByAccountUuidCommand $command): void
    {
        $this->repository->cancelExpense(
            uuid: $command->getUuid(),
            id: $command->getId()
        );
    }
}
