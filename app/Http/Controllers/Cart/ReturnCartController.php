<?php

namespace App\Http\Controllers\Cart;

use App\Http\Controllers\Controller;
use Gloudemans\Shoppingcart\Facades\Cart;

class ReturnCartController extends Controller
{
    public function cart()
    {
        $cartItems = Cart::content();
        return view('customer/cart', ['cartItems' => $cartItems]);
    }
}

?>