<?php

namespace App\Domains\Balance\Application\Controllers\Api;

use App\Domains\Balance\Application\Projectors\BalanceProjector;
use App\Http\Controllers\Controller;
use App\Interfaces\Query\QueryBus;
use Illuminate\Http\JsonResponse;

class BalanceController extends Controller
{
    /**
     * @param QueryBus $queryBus
     * @param BalanceProjector $projector
     * @return JsonResponse
     */
    public function index(QueryBus $queryBus, BalanceProjector $projector): JsonResponse
    {
        $history = $projector->getBalance(auth()->user()->account->uuid);

        return response()->json($history);
    }
}
