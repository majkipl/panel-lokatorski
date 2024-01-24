<?php

namespace App\Domains\User\Application\Commands\SaveAccount;

use App\Domains\User\Domain\Repositories\AccountRepositoryInterface;

class SaveAccountHandler
{
    /**
     * @param AccountRepositoryInterface $repository
     */
    public function __construct(protected AccountRepositoryInterface $repository)
    {
    }

    /**
     * @param SaveAccountCommand $command
     * @return bool
     */
    public function handle(SaveAccountCommand $command): bool
    {
        return $this->repository->save(
            attributes: $command->getAttributes(),
        );
    }
}
