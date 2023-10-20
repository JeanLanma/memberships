<?php

namespace App\Http\Controllers\Billing;

use Laravel\Cashier\Exceptions\IncompletePayment;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Stripe\StripeClient;
use App\Models\Country;
use App\Services\Stripe\StripePlanAdapter;

class BillingController extends Controller
{
    public function paymentMethodForm() {
        $countries = Country::all();
        return view('front.billing.payment_method_form', [
            'intent' => auth()->user()->createSetupIntent(),
            'countries' => $countries,
        ]);
    }

    /**
     * @throws CustomerAlreadyCreated
     */
    public function processPaymentMethod() {
        $this->validate(request(), [
            "pm" => "required|string|starts_with:pm_|max:50",
            "card_holder_name" => "required|max:150|string",
            "country_id" => "required|exists:countries,id",
        ]);

        if (!auth()->user()->hasStripeId()) {
            auth()->user()->createAsStripeCustomer([
                "address" => [
                    "country" => Country::find(request("country_id"))->code,
                ]
            ]);
        }
        auth()->user()->updateDefaultPaymentMethod(request("pm"));
        return redirect()->route('billing.my_subscription')
            ->with('notification', [
                'title' => __("¡Método de pago actualizado!"),
                'message' => __("Tu método de pago ha sido actualizado correctamente")
            ]);
    }

    public function plans()
    {
        if (!auth()->user()->hasDefaultPaymentMethod()) {
            return redirect()->route('billing.payment_method_form');
        }
        if( auth()->user()->subscribed() ) {
            return redirect()->route('billing.my_subscription');
        }
        $key = config("cashier.secret");
        $stripe = new StripeClient($key);

        $plans = $stripe->plans->all(StripePlanAdapter::GetPlanParameters());

        $plans = $plans->data;
        
        foreach ($plans as $plan) {
            $plan->metadata = StripePlanAdapter::PlanMetadataAdapter($plan);
            $plan->features = StripePlanAdapter::FilterPlanFeatures($plan->metadata);
        }
        // dd($plans);
        return view("front.billing.plans", [
            "plans" => $plans,
        ]);
    }

    /**
     * @throws ApiErrorException
     */
    public function processSubscription() {
        $this->validate(request(), [
            "price_id" => "required|string|starts_with:price_",
        ]);

        $key = config('cashier.secret');
        $stripe = new StripeClient($key);
        $plan = $stripe->plans->retrieve(request("price_id"));
        try {

            if(request()->has('promo_code')) {
                auth()
                ->user()
                ->newSubscription('default', request("price_id"))
                ->trialDays(30)
                ->create(auth()->user()->defaultPaymentMethod()->id);
            } else {
                auth()
                ->user()
                ->newSubscription('default', request("price_id"))
                ->create(auth()->user()->defaultPaymentMethod()->id);
            }



                return redirect(route("billing.my_subscription"))
                    ->with('notification', [
                        'title' => __("¡Gracias por contratar un plan!"),
                        'message' => __('Te has suscrito al plan ' . getPlanNameByStripePlan($plan) . ' correctamente, recuerda revisar tu correo electrónico por si es necesario confirmar el pago')
                    ]);
        } catch (IncompletePayment $exception) {
            return redirect()->route(
                'cashier.payment',
                [$exception->payment->id, 'redirect' => route("billing.my_subscription")]
            );
        } catch (\Exception $exception) {
            return back()->with('notification', [
                'title' => __("Error"),
                'message' => $exception->getMessage()
            ]);
        }
    }

    public function mySubscription()
    {
        $subscription = getSubscriptionNameForUser();
        return view("front.billing.my_subscription", compact("subscription"));
    }
}
