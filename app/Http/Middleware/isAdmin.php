<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class isAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {

        // $user = User::where('id' , Auth::user()->id)->first();

        // dd((Auth::user()));
        if(Auth::user()->role_id != 1){
            return response()->json([
                "code" => 403,
                "message" => "Can Not Access This Information"
            ]);
        }

        return $next($request);
    }
}
