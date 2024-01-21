<?php

namespace App\Domains\Expense\Application\Controllers\Api;

use App\Domains\Billing\Application\Projectors\BillingProjector;
use App\Domains\User\Application\Queries\FindAccountsUuidByUserRoleAndStatus\FindAccountsUuidByUserRoleAndStatusQuery;
use App\Domains\User\Application\Queries\FindUserByAccountUuid\FindUserByAccountUuidQuery;
use App\Domains\User\Domain\Enums\UserRole;
use App\Domains\User\Domain\Enums\UserStatus;
use App\Http\Controllers\Controller;
use App\Interfaces\Query\QueryBus;
use Illuminate\Http\JsonResponse;

class ExpenseController extends Controller
{
    /**
     * @param QueryBus $queryBus
     * @param BillingProjector $projector
     * @return JsonResponse
     */
    public function index(QueryBus $queryBus, BillingProjector $projector): JsonResponse
    {
        $uuids = $queryBus->ask(
            query: new FindAccountsUuidByUserRoleAndStatusQuery(
                status: UserStatus::ACTIVE->value,
                role: [UserRole::ADMIN->value, UserRole::USER->value]
            )
        );

        $expenses = [];
        foreach ($uuids as $uuid) {
            $user = $queryBus->ask(
                query: new FindUserByAccountUuidQuery(
                    uuid: $uuid
                )
            );

            $billing = $projector->getBilllingForNow($uuid);
            $expenses[$user->firstname . ' ' . $user->lastname] = $billing->expense;
        }

        return response()->json($expenses);
    }
}
