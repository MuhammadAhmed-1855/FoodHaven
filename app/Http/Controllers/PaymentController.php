<?php

namespace App\Http\Controllers;

use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\Redirect;
use App\Models\FoodItem;
use App\Models\User;
use Stripe\Stripe;

class PaymentController extends Controller
{
    public function checkout() {
        $cartItems = Cart::content();
        
        $sk = env('SK_STRIPE');

        \Stripe\Stripe::setApiKey($sk);
        header('Content-Type: application/json');

        $line_items = [];
        $platformfee = 0;

        foreach ($cartItems as $item) {

            $options = $item->options;
            $foodItem = FoodItem::find($options->id);
            $cook = User::find($foodItem->user_id);
            echo "<br>";
            echo $cook;
            $stripeAccount = $cook->stripe_account_id;

            $unit_amount = ceil($item->price * 1.17);
            echo "<br>";
            echo $unit_amount;
            echo "<br>";

            $line_items[] = [
                'price_data' => [
                    'currency' => 'pkr',
                    'product_data' => [
                        'name' => $item->name,
                    ],
                    'unit_amount' => $unit_amount * 100,
                ],
                'quantity' => $item->qty,
            ];

            $platformfee += ($item->price * 0.005);
        }

        echo $platformfee;
        echo json_encode($line_items);



        $session = \Stripe\Checkout\Session::create([
            'line_items' => $line_items,
            'payment_intent_data' => [
                'application_fee_amount' => $platformfee * 100,
                'transfer_data' => [
                    'destination' => $stripeAccount,
                ],
            ],
            'mode' => 'payment',
            'success_url' => 'http://127.0.0.1:8000/customer/success',
        ]);

        return Redirect::away($session->url);
    }

    public function success() {
        Cart::destroy();
        return view('customer/success');
    }

    public function addStripe() {
        echo "Stripe Account";

        $sk = env('SK_STRIPE');
        \Stripe\Stripe::setApiKey($sk);

        $account = \Stripe\Account::create([
            'type' => 'express',
        ]);

        $stripe = new \Stripe\StripeClient($sk);

        $accountLinks = $stripe->accountLinks->create([
            'account' => $account->id,
            'refresh_url' => 'http://127.0.0.1:8000/cook/dashboard',
            'return_url' => 'http://127.0.0.1:8000/cook/success',
            'type' => 'account_onboarding',
        ]);

        $user = User::find(auth()->user()->id);
        $user->stripe_account_id = $account->id;

        $user->save();

        return Redirect::away($accountLinks->url);
    }
}
