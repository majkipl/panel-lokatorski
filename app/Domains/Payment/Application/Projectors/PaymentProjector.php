<?php

namespace App\Domains\Payment\Application\Projectors;

use App\Domains\Payment\Application\Commands\Save\SaveCommand;
use App\Domains\Payment\Application\Commands\UpdateProjection\UpdateProjectionCommand;
use App\Domains\Payment\Application\Queries\FindLatestPaymentByAccountUuid\FindLatestPaymentByAccountUuidQuery;
use App\Domains\Payment\Application\Queries\FindLatestPayments\FindAllLatestPaymentsQuery;
use App\Domains\Payment\Domain\Events\MoneyAdded;
use App\Domains\Payment\Domain\Events\MoneySubtracted;
use App\Domains\User\Application\Queries\FindUserByAccountUuid\FindUserByAccountUuidQuery;
use App\Domains\User\Domain\Events\AccountCreated;
use App\Interfaces\Command\CommandBus;
use App\Interfaces\Query\QueryBus;
use Carbon\Carbon;
use Spatie\EventSourcing\EventHandlers\Projectors\Projector;

class PaymentProjector extends Projector
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
     * @param MoneyAdded $event
     * @return void
     */
    public function onMoneyAdded(MoneyAdded $event): void
    {
        $metaData = $event->metaData();
        $createdAt = Carbon::parse($metaData['created-at']);

        $projection = $this->queryBus->ask(
            query: new FindLatestPaymentByAccountUuidQuery(
                uuid: $event->accountUuid
            )
        );
        $payments = unserialize($projection);

        $payments[] = [
            'type' => 'MoneyAdded',
            'accountUuid' => $event->accountUuid,
            'amount' => $event->amount,
            'created_at' => $createdAt,
            'created_year' => $createdAt->year,
            'created_month' => $createdAt->locale('pl')->isoFormat('MMMM'),
            'created_day' => $createdAt->day,
            'user' => $this->queryBus->ask(
                query: new FindUserByAccountUuidQuery(
                    uuid: $event->accountUuid
                )
            )
        ];

        $this->commandBus->dispatch(
            command: new UpdateProjectionCommand(
                uuid: $event->accountUuid,
                projection: serialize($payments)
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
            query: new FindLatestPaymentByAccountUuidQuery(
                uuid: $event->accountUuid
            )
        );
        $payments = unserialize($projection);

        $payments[] = [
            'type' => 'MoneySubtracted',
            'accountUuid' => $event->accountUuid,
            'amount' => $event->amount,
            'created_at' => $createdAt,
            'created_year' => $createdAt->year,
            'created_month' => $createdAt->locale('pl')->isoFormat('MMMM'),
            'created_day' => $createdAt->day,
            'user' => $this->queryBus->ask(
                query: new FindUserByAccountUuidQuery(
                    uuid: $event->accountUuid
                )
            )
        ];

        $this->commandBus->dispatch(
            command: new UpdateProjectionCommand(
                uuid: $event->accountUuid,
                projection: serialize($payments)
            )
        );
    }

    /**
     * @return array
     */
    public function getAllOperations(): array
    {
        return $this->queryBus->ask(
            query: new FindAllLatestPaymentsQuery()
        );
    }
}
