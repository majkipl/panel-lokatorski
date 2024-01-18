<?php

namespace App\Domains\User\Application\Projectors;

use App\Domains\Payment\Domain\Events\MoneyAdded;
use App\Domains\Payment\Domain\Events\MoneySubtracted;
use App\Domains\User\Domain\Events\AccountCreated;
use App\Domains\User\Domain\Events\AccountDeleted;
use App\Domains\User\Domain\Models\Account;
use Spatie\EventSourcing\EventHandlers\Projectors\Projector;

class AccountBalanceProjector extends Projector
{
    /**
     * @param AccountCreated $event
     * @return void
     */
    public function onAccountCreated(AccountCreated $event): void
    {
        if (!Account::where('user_id', $event->accountAttributes['user_id'])->exists()) {
            (new Account($event->accountAttributes))->writeable()->save();
        } else {
            $account = Account::where('user_id', $event->accountAttributes['user_id'])->first();
            $account->balance = 0;
            $account->writeable()->save();
        }
    }

    /**
     * @param MoneyAdded $event
     * @return void
     */
    public function onMoneyAdded(MoneyAdded $event)
    {
        $account = Account::uuid($event->accountUuid);

        $account->balance += $event->amount;

        $account->writeable()->save();
    }

    /**
     * @param MoneySubtracted $event
     * @return void
     */
    public function onMoneySubtracted(MoneySubtracted $event): void
    {
        $account = Account::uuid($event->accountUuid);

        $account->balance -= $event->amount;

        $account->writeable()->save();
    }

    /**
     * @param AccountDeleted $event
     * @return void
     */
    public function onAccountDeleted(AccountDeleted $event): void
    {
        Account::uuid($event->accountUuid)->writeable()->delete();
    }
}
