<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;

class DashboardController extends Controller
{
    /**
     * @return Application|Factory|View|\Illuminate\Foundation\Application
     */
    public function dashboard()
    {
        return view(
            'dashboard'
        );
    }
}
