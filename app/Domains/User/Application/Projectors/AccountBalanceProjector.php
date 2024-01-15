<?php

namespace App\Domains\User\Application\Projectors;

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
     * @param AccountDeleted $event
     * @return void
     */
    public function onAccountDeleted(AccountDeleted $event): void
    {
        Account::uuid($event->accountUuid)->writeable()->delete();
    }
}
