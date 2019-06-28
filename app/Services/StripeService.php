<?php 

namespace App\Services;

use Illuminate\Http\Request;
use Stripe;

class StripeService extends TransformerService{

  public function stripe(Request $request)
  {
    return view('admin.stripe.stripe');
  }

  public function stripePost(Request $request) {
    // Handling Payment
    Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
    Stripe\Charge::create ([
            "amount" => 100 * 100,
            "currency" => "usd",
            "source" => $request->stripeToken,
            "description" => "Advo test payment." 
    ]);
    Session::flash('success', 'Payment successful!');
    return back();
  }

	public function transform($badge){
		return [
    ];
	}
}