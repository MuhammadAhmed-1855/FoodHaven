<?php

namespace App\Http\Controllers\Cart;

use App\Http\Controllers\Controller;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;

class RemoveItemController extends Controller
{
    public function removeCartItem(Request $req)
    {
        $id = $req->input('rowId');
        echo $id;
        Cart::remove($id);
        return redirect()->route('customer/cart');
    }
}

?>