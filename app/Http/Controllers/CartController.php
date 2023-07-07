<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FoodItem;
use Gloudemans\Shoppingcart\Facades\Cart;

class CartController extends Controller
{
    
    public function addToCart(Request $req) {
        $foodId = $req->input('food_id');
        $customerId = $req->input('customer_id');
        $quantity = $req->input('quantity');

        $foodItem = FoodItem::find($foodId);

        $id = uniqid();

        $cartItem = Cart::add($customerId, $foodItem->name, $quantity, $foodItem->price, ['image' => $foodItem->image])->associate('FoodItem');

        Cart::store($id);

        return redirect()->route('customer/cart');
    }

    public function cart() {
        // Return all cart items
        $cartItems = Cart::content();
        return view('customer/cart', ['cartItems' => $cartItems]);
    }

    public function removeCartItem(Request $req) {
        $id = $req->input('rowId');
        echo $id;
        Cart::remove($id);
        return redirect()->route('customer/cart');
    }
}
