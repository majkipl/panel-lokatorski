<?php

namespace App\Domains\Payment\Application\Controllers;

use App\Domains\Payment\Application\Projectors\PaymentProjector;
use App\Domains\Payment\Application\Requests\StoreRequest;
use App\Domains\User\Application\Commands\AddMoneyByUserId\AddMoneyByUserIdCommand;
use App\Domains\User\Application\Commands\SubtractMoneyByUserId\SubtractMoneyByUserIdCommand;
use App\Domains\User\Application\Queries\FindUsersByStatusAndRole\FindUsersByStatusAndRoleQuery;
use App\Domains\User\Domain\Enums\UserRole;
use App\Http\Controllers\Controller;
use App\Interfaces\Command\CommandBus;
use App\Interfaces\Query\QueryBus;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class PaymentController extends Controller
{
    /**
     * @param PaymentProjector $paymentProjector
     * @return Application|Factory|View|\Illuminate\Foundation\Application
     */
    public function index(PaymentProjector $paymentProjector): Factory|View|\Illuminate\Foundation\Application|Application
    {
        $op_assoc = array();
        $operations = $paymentProjector->getAllOperations();

        foreach ($operations as $key => $op) {
            $op_assoc[$op['created_year']][$op['created_month']][] = $op;
        }

        return view(
            'admin.payment.index',
            [
                'operations' => $op_assoc
            ]
        );
    }

    /**
     * @return Factory|\Illuminate\Foundation\Application|View|Application
     */
    public function form(QueryBus $queryBus)
    {
        return view(
            'admin.payment.form',
            [
                'users' => $queryBus->ask(
                    query: new FindUsersByStatusAndRoleQuery(
                        role: [UserRole::ADMIN->value, UserRole::USER->value]
                    )
                )
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
        if ($request->amount > 0) {
            $commandBus->dispatch(
              command: new AddMoneyByUserIdCommand(
                  id: $request->user_id,
                  amount: $request->amount
                )
            );
        } else {
            $commandBus->dispatch(
                command: new SubtractMoneyByUserIdCommand(
                    id: $request->user_id,
                    amount: abs($request->amount)
                )
            );
        }

        return redirect()->route('admin.payment')->with('success', 'Form submitted successfully!');
    }
}

