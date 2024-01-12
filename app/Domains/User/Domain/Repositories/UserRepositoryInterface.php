<?php

namespace App\Domains\User\Domain\Repositories;

use Illuminate\Database\Eloquent\Collection;

interface UserRepositoryInterface
{
    /**
     * @return Collection
     */
    public function getAllUsers(): Collection;
}
