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
        if(auth()->check())
        {
            return $next($request);
        }
        else if($request->has('handShake') && $request->has('user_id'))
        {
            $ProjobiHandshake = 'secret';
            // Check if request is from projobi
            if($request->handShake != $ProjobiHandshake)
            {
                return redirect()->back();
            }

            // check if user
            if(!isset($request->user_id) || !isset($request->handShake))
            {
                return redirect()->back();
            }
            // check if user exists
            $ProjobiUser = GetProjobiUserService::getUserById($request->user_id);
            if(!$ProjobiUser)
            {
                return abort(404);
            }

            // check if user exists in our database
            $user = \App\Models\User::where('projobi_user_id', $request->user_id)->orWhere('email', $ProjobiUser->email)->first();
            if(!$user)
            {
                // create user
                $user = \App\Services\Projobi\PostProjobiUserService::postProjobiUser($ProjobiUser);
                // login user
                auth()->loginUsingId($user->id);
            }
            auth()->loginUsingId($user->id);

            return $next($request);
        }
        return $next($request);
    }
}
