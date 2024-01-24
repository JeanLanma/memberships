<?php

namespace App\Http\Controllers\Billing;

use Laravel\Cashier\Exceptions\IncompletePayment;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Stripe\StripeClient;
use App\Models\Country;
use App\Services\Projobi\UpdateProjobiUserService;
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

            if(true) {
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
        return view("front.standby.my_subscription", compact("subscription"));
    }

    public function applyPromoCode()
    {
        $promoCode = request("promo_code");
        $subscription = auth()->user()->subscription('default');
        $oldTrialEndsAt = $subscription->trial_ends_at;

        if ($this->isValidPromoCode($promoCode, $oldTrialEndsAt)) {
            try {
                $subscription->extendTrial(
                    $subscription->trial_ends_at->addDays(30)
                );
                $updateProjobiUser = UpdateProjobiUserService::UpdateSubscriptionTrialEndsAt(auth()->user()->projobi_user_id, $subscription->trial_ends_at);
                
                return response()->json([
                    "message" => "¡Codigo aplicado correctamente, su subscripción ha aumentado 30 dias!",
                    "success" => true,
                    "promo_code" => $promoCode,
                    "is_valid_promo_code" => true,
                    "user_subscription_trial_ends_at" => $subscription->trial_ends_at,
                    "user_subscription_old_trial_ends_at" => $oldTrialEndsAt,
                    "update_projobi_user" => $updateProjobiUser,
                ]);
            } catch (\Throwable $th) {
                return response()->json([
                    "message" => "Error al actualizar su subscripcion!",
                    "success" => false,
                    "is_valid_promo_code" => false,
                    "user_subscription_trial_ends_at" => $subscription->trial_ends_at,
                    "user_subscription_old_trial_ends_at" => $oldTrialEndsAt,
                ]);
            }
        } else {
            return response()->json([
                "message" => "¡Codigo invalido o no aplica!",
                "success" => false,
                "is_valid_promo_code" => false,
                "user_subscription_trial_ends_at" => $subscription->trial_ends_at,
                "user_subscription_old_trial_ends_at" => $oldTrialEndsAt,
            ]);
        }
    }

    public function limitSubscriptionTrial($trialEndsAt)
    {
        $trialEndsAt = \Carbon\Carbon::parse($trialEndsAt);
        $nowPlusDays = \Carbon\Carbon::now()->addDays(33);
        return $trialEndsAt->lessThan($nowPlusDays);
    }

    public function isValidPromoCode($promoCode, $trialEndsAt)
    {
        return $promoCode === "PROJOBI30" && $this->limitSubscriptionTrial($trialEndsAt);
    }

    public function extendUserSubscription()
    {
        $user = auth()->user();
        $user->subscription('default')->extend();
        return redirect()->route('billing.my_subscription')
            ->with('notification', [
                'title' => __("¡Gracias por contratar un plan!"),
                'message' => __('Tu suscripción ha sido extendida correctamente')
            ]);
    }
}
