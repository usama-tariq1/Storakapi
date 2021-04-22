<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IsValidEmail
{
    /**
     * Routes that should skip handle.
     *
     * @var array
     */
    protected $except = [
        //
        '/auth/register',
        '/auth/login',
    ];



    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */

    public function handle(Request $request, Closure $next)
    {
        if(Auth::user()->email_verified_at == null){
            return response()->json(
                [
                    "code" => 403,
                    "message" => "Email Verification is Required"
                ]
            );
        }
        return $next($request);
    }
}
