<?php

namespace App\Domains\User\Application\Commands\CreateUser;

use App\Domains\User\Domain\Repositories\UserRepositoryInterface;

class CreateUserHandler
{
    /**
     * @param UserRepositoryInterface $repository
     */
    public function __construct(protected UserRepositoryInterface $repository)
    {
    }

    /**
     * @param CreateUserCommand $command
     * @return bool
     */
    public function handle(CreateUserCommand $command): bool
    {
        return $this->repository->create(
            dto: $command->getDto(),
        );
    }
}
