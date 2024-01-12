<?php

namespace App\Domains\User\Application\Controllers;

use App\Domains\User\Application\Commands\CreateUser\CreateUserCommand;
use App\Domains\User\Application\Commands\UpdateUserStatus\UpdateUserStatusCommand;
use App\Domains\User\Application\DTO\UserDTO;
use App\Domains\User\Application\Queries\FindAllUsers\FindAllUsersQuery;
use App\Domains\User\Application\Requests\StoreRequest;
use App\Domains\User\Domain\Enums\UserRole;
use App\Domains\User\Domain\Enums\UserStatus;
use App\Domains\User\Domain\Models\User;
use App\Http\Controllers\Controller;
use App\Interfaces\Command\CommandBus;
use App\Interfaces\Query\QueryBus;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class TenantController extends Controller
{
    /**
     * @return Application|Factory|View|\Illuminate\Foundation\Application
     */
    public function index(QueryBus $queryBus): Factory|View|\Illuminate\Foundation\Application|Application
    {
        return view(
            'admin.tenant.index',
            [
                'users' => $queryBus->ask(
                    query: new FindAllUsersQuery()
                )
            ]
        );
    }
}
