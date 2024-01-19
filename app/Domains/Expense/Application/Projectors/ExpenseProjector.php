<?php

namespace App\Domains\Expense\Application\Projectors;

use App\Domains\Expense\Application\Commands\Save\SaveCommand;
use App\Domains\Expense\Application\Commands\UpdateProjection\UpdateProjectionCommand;
use App\Domains\Expense\Application\Queries\FindAllByAccountUuid\FindAllByAccountUuidQuery;
use App\Domains\Expense\Application\Queries\FindLatestExpenseByAccountUuid\FindLatestExpenseByAccountUuidQuery;
use App\Domains\Expense\Domain\Events\ExpenseAdded;
use App\Domains\Expense\Domain\Events\ExpenseCanceled;
use App\Domains\User\Application\Queries\FindUserByAccountUuid\FindUserByAccountUuidQuery;
use App\Domains\User\Domain\Events\AccountCreated;
use App\Interfaces\Command\CommandBus;
use App\Interfaces\Query\QueryBus;
use Carbon\Carbon;
use Spatie\EventSourcing\EventHandlers\Projectors\Projector;

class ExpenseProjector extends Projector
{
    /**
     * @param CommandBus $commandBus
     * @param QueryBus $queryBus
     */
    public function __construct(protected CommandBus $commandBus, protected QueryBus $queryBus)
    {
    }

    /**
     * @param AccountCreated $event
     * @return void
     */
    public function onAccountCreated(AccountCreated $event): void
    {
        $this->commandBus->dispatch(
            command: new SaveCommand(
                uuid: $event->accountAttributes['uuid'],
                projection: serialize([])
            )
        );
    }

    /**
     * @param ExpenseAdded $event
     * @return void
     */
    public function onExpenseAdded(ExpenseAdded $event): void
    {
        $metaData = $event->metaData();
        $createdAt = Carbon::parse($metaData['created-at']);

        foreach ($event->participants as $participant) {
            $projection = $this->queryBus->ask(
                query: new FindLatestExpenseByAccountUuidQuery(
                    uuid: $participant,
                )
            );
            $expenses = unserialize($projection);

            $expenses[] = [
                'type' => 'ExpenseAdded',
                'event_id' => $metaData['stored-event-id'],
                'accountUuid' => $event->accountUuid,
                'name' => $event->name,
                'amount' => $event->amount,
                'created_at' => $createdAt,
                'created_year' => $createdAt->year,
                'created_month' => $createdAt->locale('pl')->isoFormat('MMMM'),
                'created_day' => $createdAt->day,
                'canceled' => false,
                'user' => $this->queryBus->ask(
                    query: new FindUserByAccountUuidQuery(
                        uuid: $event->accountUuid
                    )
                )
            ];

            $this->commandBus->dispatch(
                command: new UpdateProjectionCommand(
                    uuid: $participant,
                    projection: serialize($expenses)
                )
            );
        }
    }

    /**
     * @param ExpenseCanceled $event
     * @return void
     */
    public function onExpenseCanceled(ExpenseCanceled $event): void
    {
        foreach ($event->participants as $participant) {
            $projection = $this->queryBus->ask(
                query: new FindLatestExpenseByAccountUuidQuery(
                    uuid: $participant,
                )
            );
            $expenses = unserialize($projection);

            foreach ($expenses as $key => $expense) {
                if ($expense['event_id'] == $event->eventId) {
                    $expenses[$key]['canceled'] = true;
                }
            }

            $this->commandBus->dispatch(
                command: new UpdateProjectionCommand(
                    uuid: $participant,
                    projection: serialize($expenses)
                )
            );
        }
    }

    /**
     * @param string|null $uuid
     * @return array
     */
    public function getAll(string $uuid = null): array
    {
        return $this->queryBus->ask(
            query: new FindAllByAccountUuidQuery(
                uuid: $uuid ?? auth()->user()->account->uuid
            )
        );
    }

    /**
     * @param string|null $uuid
     * @return array
     */
    public function getExpensesForNow(string $uuid = null): array
    {
        $expenses = $this->getAll($uuid);

        foreach ($expenses as $key => $expens) {
            if (!(Carbon::now()->year == $expens['created_year'] && Carbon::now()->locale('pl')->isoFormat('MMMM') == $expens['created_month'])) {
                unset($expenses[$key]);
            }
        }

        return $expenses;
    }

    /**
     * @param string|null $uuid
     * @return array
     */
    public function getTodaysExpenses(string $uuid = null): array
    {
        $expenses = $this->getAll($uuid);

        foreach ($expenses as $key => $expens) {
            if (!(Carbon::now()->year == $expens['created_at']->year && Carbon::now()->month == $expens['created_at']->month && Carbon::now()->day == $expens['created_at']->day)) {
                unset($expenses[$key]);
            }
        }

        return $expenses;

    }
}
