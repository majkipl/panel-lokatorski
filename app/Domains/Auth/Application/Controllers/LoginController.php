<?php

namespace App\Domains\Auth\Application\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Cookie;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * @param Request $request
     * @param $user
     * @return RedirectResponse
     */
    protected function authenticated(Request $request, $user): RedirectResponse
    {
        $token = $user->createToken('authenticated')->plainTextToken;

        // Store the token in the session so it can be used in your application
        $request->session()->put('api_token', $token);

        // Set the token as a cookie
        Cookie::queue('token', $token, 60, null, null, true, true);

        Cookie::queue(cookie('key', 'value', $minute = 10));

        // Redirect the user as normal
        return redirect()->intended($this->redirectPath());
    }

    /**
     * @param Request $request
     * @return \Illuminate\Foundation\Application|Redirector|RedirectResponse|Application
     */
    protected function loggedOut(Request $request): \Illuminate\Foundation\Application|Redirector|RedirectResponse|Application
    {
        // Usuń ciasteczko
        Cookie::queue(Cookie::forget('token'));

        // Przekieruj użytkownika do strony logowania po wylogowaniu
        return redirect('/login');
    }


}
