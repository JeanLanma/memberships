<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserIsStripeCustomer
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->user() && ! $request->user()->hasStripeId()) {
            return redirect(route("billing.payment_method_form"))
            ->with('notification', [
                'title' => __("Falta un metodo de pago"),
                'message' => __("Por favor agregue un metodo de pago primero para poder continuar."),
                'type' => 'warning'
            ]);
        }

        return $next($request);
    }
}
