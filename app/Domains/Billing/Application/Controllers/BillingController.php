<?php

namespace App\Domains\Billing\Application\Controllers;

use App\Domains\Billing\Application\Projectors\BillingProjector;
use App\Domains\User\Domain\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;

class BillingController extends Controller
{
    /**
     * @param User $user
     * @param BillingProjector $billingProjector
     * @return View|Application|Factory|\Illuminate\Contracts\Foundation\Application
     */
    public function billing(User $user, BillingProjector $billingProjector): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        $user = $user->exists ? $user : auth()->user();
        $billing = $billingProjector->getBillling($user->account->uuid)->addCumulative();

        $billing->years = array_reverse($billing->years, true);
        foreach ($billing->years as $year) {
            $year->months = array_reverse($year->months, true);
        }

        return view(
            'billing.index',
            [
                'user' => $user,
                'billing' => $billing
            ]
        );
    }
}
