<?php

namespace App\Domains\Billing\Application\Projectors;

use App\Domains\Billing\Application\Classes\BillingData;
use App\Domains\Billing\Application\Classes\MonthlyData;
use App\Domains\Billing\Application\Commands\Save\SaveCommand;
use App\Domains\Billing\Application\Commands\UpdateProjection\UpdateProjectionCommand;
use App\Domains\Billing\Application\Queries\FindLatestBillingByAccountUuid\FindLatestBillingByAccountUuidQuery;
use App\Domains\Expense\Domain\Events\ExpenseAdded;
use App\Domains\Expense\Domain\Events\ExpenseCanceled;
use App\Domains\Payment\Domain\Events\MoneyAdded;
use App\Domains\Payment\Domain\Events\MoneySubtracted;
use App\Domains\User\Domain\Events\AccountCreated;
use App\Interfaces\Command\CommandBus;
use App\Interfaces\Query\QueryBus;
use Carbon\Carbon;
use Spatie\EventSourcing\EventHandlers\Projectors\Projector;

class BillingProjector extends Projector
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
                projection: serialize(new BillingData())
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

        $year = $createdAt->locale('pl')->year;
        $month = $createdAt->locale('pl')->isoFormat('MMMM');

        $projection = $this->queryBus->ask(
            query: new FindLatestBillingByAccountUuidQuery(
                uuid: $event->accountUuid
            )
        );

        $billing = unserialize($projection);

        $billing = $billing ?? new BillingData();
        $billing->increaseBalance($event->amount);
        $billing->increasePayment($event->amount);
        $billing->getYear($year)->increaseBalance($event->amount);
        $billing->getYear($year)->increasePayment($event->amount);
        $billing->getYear($year)->getMonth($month)->increaseBalance($event->amount);
        $billing->getYear($year)->getMonth($month)->increasePayment($event->amount);

        $this->commandBus->dispatch(
          command: new UpdateProjectionCommand(
              uuid: $event->accountUuid,
              projection: serialize($billing)
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

        $year = $createdAt->locale('pl')->year;
        $month = $createdAt->locale('pl')->isoFormat('MMMM');

        $projection = $this->queryBus->ask(
            query: new FindLatestBillingByAccountUuidQuery(
                uuid: $event->accountUuid
            )
        );

        $billing = unserialize($projection);

        $billing = $billing ?? new BillingData();
        $billing->decreaseBalance($event->amount);
        $billing->decreasePayment($event->amount);
        $billing->getYear($year)->decreaseBalance($event->amount);
        $billing->getYear($year)->decreasePayment($event->amount);
        $billing->getYear($year)->getMonth($month)->decreaseBalance($event->amount);
        $billing->getYear($year)->getMonth($month)->decreasePayment($event->amount);

        $this->commandBus->dispatch(
            command: new UpdateProjectionCommand(
                uuid: $event->accountUuid,
                projection: serialize($billing)
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

        $year = $createdAt->locale('pl')->year;
        $month = $createdAt->locale('pl')->isoFormat('MMMM');

        $projection = $this->queryBus->ask(
            query: new FindLatestBillingByAccountUuidQuery(
                uuid: $event->accountUuid
            )
        );
        $billing = unserialize($projection);

        $billing = $billing ?? new BillingData();
        $billing->increaseBalance($event->amount); //u mnie zwiększa saldo
        $billing->increaseExpense($event->amount); //u mnie zwiększa wydatki
        $billing->increaseCommonExpense($event->amount);
        $billing->getYear($year)->increaseBalance($event->amount);
        $billing->getYear($year)->increaseExpense($event->amount);
        $billing->getYear($year)->increaseCommonExpense($event->amount);
        $billing->getYear($year)->getMonth($month)->increaseBalance($event->amount);
        $billing->getYear($year)->getMonth($month)->increaseExpense($event->amount);
        $billing->getYear($year)->getMonth($month)->increaseCommonExpense($event->amount);

        $this->commandBus->dispatch(
            command: new UpdateProjectionCommand(
                uuid: $event->accountUuid,
                projection: serialize($billing)
            )
        );

        $countParticipants = count($event->participants);
        $amountPerCapita = $countParticipants ? round($event->amount / $countParticipants, 2) : 0;

        foreach ($event->participants as $participant) {
            $projection = $this->queryBus->ask(
                query: new FindLatestBillingByAccountUuidQuery(
                    uuid: $participant
                )
            );
            $billing = unserialize($projection);

            $billing = $billing ?? new BillingData();
            $billing->decreaseBalance($amountPerCapita); // u każdego zmniejsza saldo PERCAPITA
            $billing->getYear($year)->decreaseBalance($amountPerCapita);
            $billing->getYear($year)->getMonth($month)->decreaseBalance($amountPerCapita);
            $billing->getYear($year)->getMonth($month)->decreaseExpensePerCapita($amountPerCapita);

            if ($event->accountUuid != $participant) {
                $billing->increaseCommonExpense($event->amount);
                $billing->getYear($year)->increaseCommonExpense($event->amount);
                $billing->getYear($year)->getMonth($month)->increaseCommonExpense($event->amount);
            }

            $this->commandBus->dispatch(
                command: new UpdateProjectionCommand(
                    uuid: $participant,
                    projection: serialize($billing)
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

        $year = $createdAt->locale('pl')->year;
        $month = $createdAt->locale('pl')->isoFormat('MMMM');

        $projection = $this->queryBus->ask(
            query: new FindLatestBillingByAccountUuidQuery(
                uuid: $event->accountUuid
            )
        );
        $billing = unserialize($projection);

        $billing = $billing ?? new BillingData();
        $billing->decreaseBalance($event->amount);
        $billing->decreaseExpense($event->amount);
        $billing->decreaseCommonExpense($event->amount);
        $billing->getYear($year)->decreaseBalance($event->amount);
        $billing->getYear($year)->decreaseExpense($event->amount);
        $billing->getYear($year)->decreaseCommonExpense($event->amount);
        $billing->getYear($year)->getMonth($month)->decreaseBalance($event->amount);
        $billing->getYear($year)->getMonth($month)->decreaseExpense($event->amount);
        $billing->getYear($year)->getMonth($month)->decreaseCommonExpense($event->amount);

        $this->commandBus->dispatch(
            command: new UpdateProjectionCommand(
                uuid: $event->accountUuid,
                projection: serialize($billing)
            )
        );

        $countParticipants = count($event->participants);
        $amountPerCapita = $countParticipants ? round($event->amount / $countParticipants, 2) : 0;

        foreach ($event->participants as $participant) {
            $projection = $this->queryBus->ask(
                query: new FindLatestBillingByAccountUuidQuery(
                    uuid: $participant
                )
            );
            $billing = unserialize($projection);

            $billing = $billing ?? new BillingData();
            $billing->increaseBalance($amountPerCapita);
            $billing->getYear($year)->increaseBalance($amountPerCapita);
            $billing->getYear($year)->getMonth($month)->increaseBalance($amountPerCapita);
            $billing->getYear($year)->getMonth($month)->increaseExpensePerCapita($amountPerCapita);

            if ($event->accountUuid != $participant) {
                $billing->decreaseCommonExpense($event->amount);
                $billing->getYear($year)->decreaseCommonExpense($event->amount);
                $billing->getYear($year)->getMonth($month)->decreaseCommonExpense($event->amount);
            }

            $this->commandBus->dispatch(
                command: new UpdateProjectionCommand(
                    uuid: $participant,
                    projection: serialize($billing)
                )
            );
        }
    }

    /**
     * @param string|null $uuid
     * @return array|BillingData
     */
    public function getBillling(string $uuid = null): array|BillingData
    {
        $projection = $this->queryBus->ask(
            query: new FindLatestBillingByAccountUuidQuery(
                uuid: $uuid ?? auth()->user()->account->uuid
            )
        );

        return $projection ? unserialize($projection) : new BillingData();
    }

    /**
     * @param string|null $uuid
     * @return MonthlyData
     */
    public function getBilllingForNow(string $uuid = null): MonthlyData
    {
        $projection = $this->queryBus->ask(
            query: new FindLatestBillingByAccountUuidQuery(
                uuid: $uuid ?? auth()->user()->account->uuid
            )
        );

        $billing = $projection ? unserialize($projection) : new BillingData();

        return $billing->addCumulative()->getYear(Carbon::now()->year)->getMonth(Carbon::now()->locale('pl')->isoFormat('MMMM'));
    }
}
