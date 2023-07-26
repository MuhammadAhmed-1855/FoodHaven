<?php

namespace App\Http\Controllers\FoodItem;

use App\Http\Controllers\Controller;
use App\Models\FoodItem;

class ReturnItemsController extends Controller
{
    public function foodItems()
    {
        $foodItems = FoodItem::all();
        return($foodItems);
        // return view('customer/foodItems', ['foodItems' => $foodItems]);
    }
}

?>