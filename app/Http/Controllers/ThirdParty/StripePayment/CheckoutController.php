<?php

namespace App\Http\Controllers\ThirdParty\StripePayment;

use App\Http\Controllers\Controller;
use App\Models\FoodItem;
use App\Models\User;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\Redirect;
use Stripe\Stripe as Stripe;
use Stripe\Checkout\Session as Session;

class CheckoutController extends Controller
{
    public function checkout()
    {
        $cartItems = Cart::content();
        
        $sk = env('SK_STRIPE');

        Stripe::setApiKey($sk);
        header('Content-Type: application/json');

        $line_items = [];
        $platformfee = 0;

        foreach ($cartItems as $item) {

            $options = $item->options;
            $foodItem = FoodItem::find($options->id);
            $cook = User::find($foodItem->user_id);
            $stripeAccount = $cook->stripe_account_id;
            $unit_amount = ceil($item->price * 1.17);

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

        $session = Session::create([
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
}

?>