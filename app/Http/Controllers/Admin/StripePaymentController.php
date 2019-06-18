<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
   
use Illuminate\Http\Request;
use Session;
use Stripe;
use App\User;
use App\FundingTransaction;
use App\FundingReceipt;
   
class StripePaymentController extends Controller
{
    /**
     * success response method.
     *
     * @return \Illuminate\Http\Response
     */
    public function stripe(Request $request)
    {
        // $userdata = $request->all();
        return view('admin.stripe.stripe'); //['userdata' => $userdata]
    }
  
    /**
     * success response method.a
     *
     * @return \Illuminate\Http\Response
     */
    public function stripePost(Request $request) {

        // Handling Payment
        Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
        $stripe = 
        Stripe\Charge::create ([
            "amount" => 100,
            "currency" => "usd",
            "source" => $request->stripeToken,
            "description" => "Advo test payment." 
        ]);
        if($stripe->status == 'succeeded' && $stripe->paid == true){
            // Create funding transaction.
            $transaction = FundingTransaction::create($request->all());
            $transaction->amount_cents *= 100;
            $transaction->save();

            // Create funding receipt
            $receipt = new FundingReceipt;
            $receipt->funding_transaction_id = $transaction->id;
            $receipt->amount_cents = $transaction->amount_cents;
            $receipt->user_id = $transaction->benefactor_id;
            $receipt->save();

        }
        Session::flash('success', 'Payment successful!');
        return back();
    }
}
