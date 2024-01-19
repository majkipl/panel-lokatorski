<?php

namespace App\Domains\Expense\Application\Controllers;

use App\Domains\Expense\Application\Projectors\ExpenseProjector;
use App\Domains\Expense\Application\Requests\CancelRequest;
use App\Domains\Expense\Application\Requests\StoreRequest;
use App\Domains\User\Application\Commands\AddExpenseByUserId\AddExpenseByUserIdCommand;
use App\Domains\User\Application\Commands\CancelExpenseByAccountUuid\CancelExpenseByAccountUuidCommand;
use App\Http\Controllers\Controller;
use App\Interfaces\Command\CommandBus;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Spatie\EventSourcing\StoredEvents\Models\EloquentStoredEvent;

class ExpenseController extends Controller
{
    /**
     * @param ExpenseProjector $expenseProjector
     * @return View|Application|Factory|\Illuminate\Contracts\Foundation\Application
     */
    public function index(ExpenseProjector $expenseProjector): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        $op_assoc = array();
        $operations = $expenseProjector->getAll();

        foreach ($operations as $key => $op) {
            $op_assoc[$op['created_year']][$op['created_month']][] = $op;
        }

        return view(
            'expense.index',
            [
                'operations' => $op_assoc
            ]
        );
    }

    /**
     * @return View|Application|Factory|\Illuminate\Contracts\Foundation\Application
     */
    public function form(): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        return view(
            'expense.form',
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
            command: new AddExpenseByUserIdCommand(
                id: Auth::user()->id,
                name: $request->name,
                amount: $request->amount
            )
        );

        return redirect()->route('expense')->with('success', 'Form submitted successfully!');
    }

    /**
     * @param CancelRequest $request
     * @param $id
     * @param CommandBus $commandBus
     * @return RedirectResponse
     */
    public function cancel(CancelRequest $request, $id, CommandBus $commandBus): RedirectResponse
    {
        $eventCanceled = EloquentStoredEvent::find($request->id)->toStoredEvent();
        $commandBus->dispatch(
            command: new CancelExpenseByAccountUuidCommand(
                uuid: $eventCanceled->event->accountUuid,
                id: $request->id
            )
        );

        return back();
    }
}
