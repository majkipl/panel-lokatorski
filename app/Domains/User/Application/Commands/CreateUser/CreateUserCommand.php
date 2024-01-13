<?php

namespace App\Domains\User\Application\Commands\CreateUser;

use App\Domains\User\Application\DTO\UserDTO;
use App\Interfaces\Command\Command;

class CreateUserCommand extends Command
{
    /**
     * @param UserDTO $dto
     */
    public function __construct(
        private readonly UserDTO $dto
    )
    {
    }

    /**
     * @return UserDTO
     */
    public function getDto(): UserDTO
    {
        return $this->dto;
    }
}
