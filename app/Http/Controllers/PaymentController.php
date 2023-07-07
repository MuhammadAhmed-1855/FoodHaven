<?php

namespace App\Http\Controllers;

use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\Redirect;

class PaymentController extends Controller
{
    public function checkout() {
        $cartItems = Cart::content();
        
        $sk = env('SK_STRIPE');

        \Stripe\Stripe::setApiKey($sk);
        header('Content-Type: application/json');

        $line_items = [];

        foreach ($cartItems as $item) {
            $taxAmount = $item->price * 0.17;
            $line_items[] = [
                'price_data' => [
                    'currency' => 'pkr',
                    'product_data' => [
                        'name' => $item->name,
                        'image' => $item->image,
                    ],
                    'unit_amount' => ($item->price + $taxAmount) * 100,
                ],
                'quantity' => $item->qty,
            ];
        }

        $checkoutSession = \Stripe\Checkout\Session::create([
            'line_items' => $line_items,
            'mode' => 'payment',
            'success_url' => 'http://127.0.0.1:8000/customer/success',
        ]);

        return Redirect::away($checkoutSession->url);
    }

    public function success() {
        Cart::destroy();
        return view('customer/success');
    }
}
