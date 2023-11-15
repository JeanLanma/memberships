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
        // dd($request->all(), $request->header('referer') );
        if(auth()->check())
        {
            return $next($request);
        }

        else if($request->has('handShake') && $request->has('user_id') && $request->header('referer') == config('projobi.projobi_home'))
        {
            // First make sure that there's no another user logged in
            if(auth()->check() && auth()->user()->projobi_user_id != $request->user_id)
            {
                auth()->logout();
                Auth::guard('web')->logout();
    
                $request->session()->invalidate();
        
                $request->session()->regenerateToken();
            }

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
            }

            auth()->loginUsingId($user->id);
        }

        return $next($request);
    }
}
