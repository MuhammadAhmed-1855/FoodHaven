<?php

namespace App\Http\Controllers\Cart;

use App\Http\Controllers\Controller;
use App\Models\FoodItem;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;

class AddItemController extends Controller
{
    public function addToCart(Request $req) {
        $foodId = $req->input('food_id');
        $customerId = $req->input('customer_id');
        $quantity = $req->input('quantity');

        $foodItem = FoodItem::find($foodId);

        $id = uniqid();

        $cartItem = Cart::add($customerId, $foodItem->name, $quantity, $foodItem->price, [
            'image' => $foodItem->image,
            'id' => $foodId,
        ])->associate('FoodItem');

        Cart::store($id);

        return redirect()->route('customer/cart');
    }
}

?>