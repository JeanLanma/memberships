<?php

namespace App\Http\Controllers\Billing;

use App\Http\Controllers\Controller;
use App\Models\Country;
use Illuminate\Http\Request;

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
        return back()
            ->with('notification', [
                'title' => __("¡Método de pago actualizado!"),
                'message' => __("Tu método de pago ha sido actualizado correctamente")
            ]);
    }
}
