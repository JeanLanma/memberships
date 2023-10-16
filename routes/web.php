<?php

use App\Enums\Stripe\StripeEvent as StripeEventEnum;
use App\Http\Controllers\Billing\BillingController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Projobi\ProjobiController;
use App\Models\Stripe\CustomerSubscriptionUpdated;
use App\Models\Stripe\CustomerUpdated;
use App\Models\Stripe\StripeEvent;
use App\Services\Stripe\StripeEventService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Stripe\Stripe;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/dashboard', function () {
        return view('dashboard');
    })->middleware(['auth', 'verified'])->name('dashboard');

    Route::controller(BillingController::class)
    ->as('billing.')
    ->prefix('billing')
    ->group(function () {
        Route::get("/payment-method", "paymentMethodForm")->name("payment_method_form");
        Route::post("/payment-method", "processPaymentMethod")->name("payment_method");

        Route::get("/plans", "plans")->name("plans")->middleware('is_stripe_customer');
        Route::post("/subscribe", "processSubscription")->name("process_subscription");
        Route::get("/my-subscription", "mySubscription")->name("my_subscription");
    });

    Route::group(["middleware" => "is_stripe_customer"], function () {
        Route::get('/billing/portal', function () {
            return auth()->user()->redirectToBillingPortal(route('dashboard'));
        })->name("billing.portal");
    });
});


Route::controller(ProjobiController::class)
    ->as('projobi.')
    ->prefix('projobi')
    ->group( function () {
        Route::get("/", "index")->name("index");
        Route::get('/users/{id}', "getUserById")->name("getUserById");
    });

Route::get('projobi-redirect', function () {
    return redirect()->away(config('projobi.logout_redirect'));
})->name('projobi.logout_redirect');
require __DIR__.'/auth.php';


Route::get('/stripe/events/{event?}', function($event = null) {
    // return response()->json(config('projobi.stripe.plans'));
    $events = $event 
            ? (StripeEvent::find($event) ?? [])
            : StripeEvent::all() ?? [];
    $EventHandler = StripeEventService::GetEventModel($events);
    dd($EventHandler);
    return response()->json($events);
})->name('stripe.events');