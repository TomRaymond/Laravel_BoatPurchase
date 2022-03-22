<?php
namespace App\Http\Controllers;
use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Mail;
use Validator;
use URL;
use Session;
use Redirect;
use Input;
use App\User;
use Stripe\Error\Card;
use App\Mail\ConfirmationEmail;

class CheckoutController extends Controller
{
    /**
     * success response method.
     *
     * @return \Illuminate\Http\Response
     */
    public function checkout()
    {   
        // Set stripe secret key 
        \Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
        
        //TODO: pull data for payment intent creation from elsewhere
		$amount = 50000000;
        $amount = (int)$amount;
        // Create payment intent for the boat
        $payment_intent = \Stripe\PaymentIntent::create([
			'description' => 'Stripe Test Payment',
			'amount' => $amount,
			'currency' => 'GBP',
			'description' => 'Payment From Codehunger',
			'payment_method_types' => ['card'],
		]);
		$intent = $payment_intent->client_secret;

		return view('checkout.credit-card', compact('intent'));
    }

    /**
     * success response method.
     *
     * @return \Illuminate\Http\Response
     */
    public function purchaseComplete(){
        $data = ['transaction_id' => '12345', 'price' => '£500,000']; //TODO: drive email content from elsewhere
        Mail::to($_POST['email'])->send(new ConfirmationEmail($data));
        return view('checkout.purchase-complete');
    }
}