<?php

namespace App\Http\Controllers\FoodItem;

use App\Http\Controllers\Controller;
use App\Models\FoodItem;
use Illuminate\Http\Request;

class CreateItemController extends Controller
{
    public function store(Request $req)
    {
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
}

?>