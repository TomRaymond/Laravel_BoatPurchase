<?php
namespace App\Http\Controllers;
use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Validator;
use URL;
use Session;
use Redirect;
use Input;
use App\User;
use Stripe\Error\Card;
//use Cartalyst\Stripe\Stripe;

class CheckoutController extends Controller
{
    /**
     * success response method.
     *
     * @return \Illuminate\Http\Response
     */
    public function checkout()
    {   
        // Enter Your Stripe Secret
        \Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
        
		$amount = 50000000;
        $amount = (int) $amount;
        
        $payment_intent = \Stripe\PaymentIntent::create([
			'description' => 'Stripe Test Payment',
			'amount' => $amount,
			'currency' => 'GBP',
			'description' => 'Payment From Codehunger',
			'payment_method_types' => ['card'],
		]);
		$intent = $payment_intent->client_secret; 

        /*
        $checkout_session = \Stripe\Checkout\Session::create([
            'success_url' => 'https://localhost/success.html?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => 'https://localhost/canceled.html',
            'mode' => 'payment',
            // 'automatic_tax' => ['enabled' => true],
            'line_items' => [[
              'price' => 'price_1Ke0hXIoZ94z7xJ0bfcK0bbR',
              'quantity' => 1,
            ]]
          ]);

          Session::flash('success', 'Payment done successfully!');
          echo $checkout_session;
          #return back(); */
        
		return view('checkout.credit-card', compact('intent'));
    }

    /**
     * success response method.
     *
     * @return \Illuminate\Http\Response
     */
    public function purchaseComplete(){
        return view('checkout.purchase-complete');
    }
}