<?php

namespace App\Http\Controllers\ThirdParty\StripePayment;

use App\Http\Controllers\Controller;
use Gloudemans\Shoppingcart\Facades\Cart;

class SuccessController extends Controller
{
    public function success()
    {
        Cart::destroy();
        return view('customer/success');
    }
}

?>