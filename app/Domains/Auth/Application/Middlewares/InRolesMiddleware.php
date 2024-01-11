<?php

namespace App\Domains\Auth\Application\Middlewares;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class InRolesMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $roles): Response
    {
        if ( !in_array($request->user()->role, explode('|',$roles)) ) {
            return redirect('/');
        }
        return $next($request);
    }
}
