<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FoodItem;
use Gloudemans\Shoppingcart\Facades\Cart;

class FoodItemController extends Controller
{
    //
    public function store(Request $req) {
        $foodItem = new FoodItem;
        $foodItem->name = $req->name;
        $foodItem->description = $req->description;
        $foodItem->price = $req->price;
        $foodItem->ingredients = $req->ingredients;
        $foodItem->category = $req->category;
        $foodItem->user_id = $req->user()->id;

        $imageFile = $req->file('image');
        $imageExtension = $imageFile->getClientOriginalExtension();
        $foodItem->image = $imageExtension;

        $foodItem->save();

        $foodItem->image = $foodItem->id . "." . $imageExtension;

        $imageFile->move('images', $foodItem->id . "." . $imageExtension);
        $foodItem->image = 'images/' . $foodItem->id . "." . $imageExtension;

        $foodItem->save();

        return redirect()->route('cook/dashboard');
    }

    public function foodItems() {
        $foodItems = FoodItem::all();
        return view('customer/foodItems', ['foodItems' => $foodItems]);
    }

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
