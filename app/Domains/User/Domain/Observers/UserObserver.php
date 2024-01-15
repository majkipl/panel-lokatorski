<?php

namespace App\Domains\User\Domain\Observers;

use App\Domains\User\Application\Mails\CreateUserMail;
use App\Domains\User\Domain\Models\Account;
use App\Domains\User\Domain\Models\User;
use Illuminate\Support\Facades\Mail;

class UserObserver
{
    /**
     * @param User $user
     * @return void
     */
    public function created(User $user): void
    {
        Account::createWithAttributes(['user_id' => $user->id]);

        Mail::send(new CreateUserMail([
            'user' => $user
        ]));
    }
}
