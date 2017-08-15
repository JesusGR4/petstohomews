<?php

namespace App\Http\Middleware;

use App\Providers\CodesServiceProvider;
use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;

class CheckShelter
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $user = Auth::user();

        if($user->role_id  != 3){
            return response(array(
                'error' => true,
                'code' => CodesServiceProvider::NO_PERMISSIONS));
        }
        return $next($request);
    }

}