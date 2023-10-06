<?php

namespace App\Http\Middleware;

use App\Services\Projobi\GetProjobiUserService;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AuthenticateProjobiUser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if(true)
        {
            return $next($request);
        }
        else 
        {
            // check if user
            if(!isset($request->user_id) || !isset($request->handShake))
            {
                return redirect()->back();
            }
            
            // check if user exists
            $ProjobiUser = GetProjobiUserService::getUserById($request->user_id);
            if(!$ProjobiUser)
            {
                return redirect()->back();
            }

            // check if handshake is correct
            // Code..

            // check if user exists in our database
            $ProjobiUser = \App\Models\User::where('projobi_user_id', $request->user_id)->first();
            if(!$ProjobiUser)
            {
                // create user
                $user = \App\Services\Projobi\PostProjobiUserService::postProjobiUser($ProjobiUser);
                // login user
                auth()->loginUsingId($user->id);
            }
            // dd($request->all(), GetProjobiUserService::getUserById($request->user_id));
            return $next($request);
        }
        return $next($request);
    }
}
