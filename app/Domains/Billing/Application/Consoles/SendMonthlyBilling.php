<?php

namespace App\Domains\Billing\Application\Consoles;

use App\Domains\Billing\Application\Mails\BillingMail;
use App\Domains\Billing\Application\Projectors\BillingProjector;
use App\Domains\Expense\Application\Projectors\ExpenseProjector;
use App\Domains\User\Application\Queries\FindUsersByStatusAndRole\FindUsersByStatusAndRoleQuery;
use App\Domains\User\Domain\Enums\UserRole;
use App\Domains\User\Domain\Enums\UserStatus;
use App\Interfaces\Query\QueryBus;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class SendMonthlyBilling extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'email:send-monthly-billing';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send monthly billing.';

    /**
     * Execute the console command.
     */
    public function handle(QueryBus $queryBus, ExpenseProjector $expenseProjector, BillingProjector $billingProjector): void
    {
        $users = $queryBus->ask(
            query: new FindUsersByStatusAndRoleQuery(
                role: [UserRole::ADMIN->value, UserRole::USER->value],
                status: UserStatus::ACTIVE->value
            )
        );

        foreach ($users as $user) {
            Mail::send(new BillingMail([
                'expenses' => $expenseProjector->getExpensesForNow($user->account->uuid),
                'billing' => $billingProjector->getBilllingForNow($user->account->uuid),
                'user' => $user
            ]));
        }
    }
}
