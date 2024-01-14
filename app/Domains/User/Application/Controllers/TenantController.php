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

    /**
     * @return View|\Illuminate\Foundation\Application|Factory|Application
     */
    public function form(): View|\Illuminate\Foundation\Application|Factory|Application
    {
        return view(
            'admin.tenant.form',
            [
                'roles' => array_map(fn($case) => $case->value, UserRole::cases()),
                'statuses' => array_map(fn($case) => $case->value, UserStatus::cases())
            ]
        );
    }

    /**
     * @param StoreRequest $request
     * @param CommandBus $commandBus
     * @return RedirectResponse
     */
    public function store(StoreRequest $request, CommandBus $commandBus): RedirectResponse
    {
        $commandBus->dispatch(
            command: new CreateUserCommand(
                dto: new UserDTO(
                    email: $request->email,
                    firstname: $request->firstname,
                    lastname: $request->lastname,
                    password: $request->password,
                    status: UserStatus::from($request->status),
                    role: UserRole::from($request->role)
                )
            )
        );

        return redirect()->route('admin.tenant')->with('success', 'Form submitted successfully!');
    }

    /**
     * @param User $user
     * @param CommandBus $commandBus
     * @return RedirectResponse
     */
    public function lock(User $user, CommandBus $commandBus): RedirectResponse
    {
        $commandBus->dispatch(
            command: new UpdateUserStatusCommand(
                id: $user->id,
                status: UserStatus::INACTIVE->value
            )
        );

        return redirect()->route('admin.tenant')->with('success', 'Change status successfully!');
    }

    /**
     * @param User $user
     * @param CommandBus $commandBus
     * @return RedirectResponse
     */
    public function unlock(User $user, CommandBus $commandBus): RedirectResponse
    {
        $commandBus->dispatch(
            command: new UpdateUserStatusCommand(
                id: $user->id,
                status: UserStatus::ACTIVE->value
            )
        );

        return redirect()->route('admin.tenant')->with('success', 'Change status successfully!');
    }
}
