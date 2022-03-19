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
        info( $payment_intent->id);

		return view('checkout.credit-card', compact('intent'));
    }

    /**
     * success response method.
     *
     * @return \Illuminate\Http\Response
     */
    public function purchaseComplete(){
        $data = ['transaction_id' => '12345', 'price' => '500,000'];
        Mail::to($_POST['email'])->send(new ConfirmationEmail($data));
        return view('checkout.purchase-complete');
    }
}