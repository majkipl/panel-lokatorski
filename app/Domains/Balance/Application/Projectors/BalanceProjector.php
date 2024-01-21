<?php

namespace App\Domains\Balance\Application\Projectors;

use App\Domains\Balance\Application\Commands\Save\SaveCommand;
use App\Domains\Balance\Application\Commands\UpdateProjection\UpdateProjectionCommand;
use App\Domains\Balance\Application\Queries\FindLatestBalanceByAccountUuid\FindLatestBalanceByAccountUuidQuery;
use App\Domains\Expense\Domain\Events\ExpenseAdded;
use App\Domains\Expense\Domain\Events\ExpenseCanceled;
use App\Domains\Payment\Domain\Events\MoneyAdded;
use App\Domains\Payment\Domain\Events\MoneySubtracted;
use App\Domains\User\Application\Queries\FindUserByAccountUuid\FindUserByAccountUuidQuery;
use App\Domains\User\Domain\Events\AccountCreated;
use App\Interfaces\Command\CommandBus;
use App\Interfaces\Query\QueryBus;
use Carbon\Carbon;
use Spatie\EventSourcing\EventHandlers\Projectors\Projector;

class BalanceProjector extends Projector
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
        $user = $this->queryBus->ask(
            query: new FindUserByAccountUuidQuery(
                uuid: $event->accountAttributes['uuid']
            )
        );

        $this->commandBus->dispatch(
            command: new SaveCommand(
                uuid: $event->accountAttributes['uuid'],
                projection: serialize([
                    Carbon::parse($user->created_at)->timestamp => 0
                ])
            )
        );
    }

    /**
     * @param MoneyAdded $event
     * @return void
     */
    public function onMoneyAdded(MoneyAdded $event): void
    {
        $metaData = $event->metaData();
        $createdAt = Carbon::parse($metaData['created-at']);

        $projection = $this->queryBus->ask(
            query: new FindLatestBalanceByAccountUuidQuery(
                uuid: $event->accountUuid
            )
        );

        $balance = unserialize($projection);

        $balance[$createdAt->timestamp] = end($balance) + $event->amount;

        $this->commandBus->dispatch(
          command: new UpdateProjectionCommand(
              uuid: $event->accountUuid,
              projection: serialize($balance)
            )
        );
    }

    /**
     * @param MoneySubtracted $event
     * @return void
     */
    public function onMoneySubtracted(MoneySubtracted $event): void
    {
        $metaData = $event->metaData();
        $createdAt = Carbon::parse($metaData['created-at']);

        $projection = $this->queryBus->ask(
            query: new FindLatestBalanceByAccountUuidQuery(
                uuid: $event->accountUuid
            )
        );

        $balance = unserialize($projection);

        $balance[$createdAt->timestamp] = end($balance) - $event->amount;

        $this->commandBus->dispatch(
            command: new UpdateProjectionCommand(
                uuid: $event->accountUuid,
                projection: serialize($balance)
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

        $projection = $this->queryBus->ask(
            query: new FindLatestBalanceByAccountUuidQuery(
                uuid: $event->accountUuid
            )
        );
        $balance = unserialize($projection);

        $balance[$createdAt->timestamp] = end($balance) + $event->amount;

        $this->commandBus->dispatch(
            command: new UpdateProjectionCommand(
                uuid: $event->accountUuid,
                projection: serialize($balance)
            )
        );

        $countParticipants = count($event->participants);
        $amountPerCapita = $countParticipants ? round($event->amount / $countParticipants, 2) : 0;

        foreach ($event->participants as $participant) {
            $projection = $this->queryBus->ask(
                query: new FindLatestBalanceByAccountUuidQuery(
                    uuid: $participant
                )
            );

            $balanceParticipant = unserialize($projection);

            $balanceParticipant[$createdAt->timestamp] = end($balanceParticipant) - $amountPerCapita;

            $this->commandBus->dispatch(
                command: new UpdateProjectionCommand(
                    uuid: $participant,
                    projection: serialize($balanceParticipant)
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
        $metaData = $event->metaData();
        $createdAt = Carbon::parse($metaData['created-at']);

        $projection = $this->queryBus->ask(
            query: new FindLatestBalanceByAccountUuidQuery(
                uuid: $event->accountUuid
            )
        );
        $balance = unserialize($projection);

        $balance[$createdAt->timestamp] = end($balance) - $event->amount;

        $this->commandBus->dispatch(
            command: new UpdateProjectionCommand(
                uuid: $event->accountUuid,
                projection: serialize($balance)
            )
        );

        $countParticipants = count($event->participants);
        $amountPerCapita = $countParticipants ? round($event->amount / $countParticipants, 2) : 0;

        foreach ($event->participants as $participant) {
            $projection = $this->queryBus->ask(
                query: new FindLatestBalanceByAccountUuidQuery(
                    uuid: $participant
                )
            );
            $balanceParticipant = unserialize($projection);

            $balanceParticipant[$createdAt->timestamp] = end($balanceParticipant) + $amountPerCapita;

            $this->commandBus->dispatch(
                command: new UpdateProjectionCommand(
                    uuid: $participant,
                    projection: serialize($balanceParticipant)
                )
            );
        }
    }

    /**
     * @param string|null $uuid
     * @return array
     */
    public function getBalance(string $uuid = null): array
    {
        $projection = $this->queryBus->ask(
            query: new FindLatestBalanceByAccountUuidQuery(
                uuid: $uuid ?? auth()->user()->account->uuid
            )
        );

        return $projection ? unserialize($projection) : [];
    }
}
