<?php

namespace App\Domains\Expense\Application\Consoles;

use App\Domains\Expense\Application\Mails\ExpensesMail;
use App\Domains\Expense\Application\Projectors\ExpenseProjector;
use App\Domains\User\Application\Queries\FindUsersByStatusAndRole\FindUsersByStatusAndRoleQuery;
use App\Domains\User\Domain\Enums\UserRole;
use App\Domains\User\Domain\Enums\UserStatus;
use App\Interfaces\Query\QueryBus;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class SendDailyExpenses extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'email:send-daily-expenses';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send daily expenses.';

    /**
     * Execute the console command.
     */
    public function handle(QueryBus $queryBus, ExpenseProjector $expenseProjector): void
    {
        $users = $queryBus->ask(
            query: new FindUsersByStatusAndRoleQuery(
                role: [UserRole::ADMIN->value, UserRole::USER->value],
                status: UserStatus::ACTIVE->value
            )
        );

        foreach ($users as $user) {
            Mail::send(new ExpensesMail([
                'expenses' => $expenseProjector->getTodaysExpenses($user->account->uuid),
                'user' => $user
            ]));
        }
    }
}
