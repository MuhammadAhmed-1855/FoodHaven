<?php

namespace App\Http\Controllers\FoodItem;

use App\Http\Controllers\Controller;
use App\http\Controllers\FoodItem\ReturnItemsController as Items;

class FoodItemWEBController extends Controller
{
    public function getItems()
    {
        $items = new Items();
        $allItems = $items->foodItems();
        return( view('customer/foodItems', ['foodItems' => $allItems]));
    }
}

?>