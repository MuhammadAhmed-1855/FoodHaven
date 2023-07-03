<?php

use App\Http\Controllers\FoodItemController;
use App\Http\Controllers\ProfileController;
use App\Models\FoodItem;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/admin/dashboard', function () {
    return view('admin/dashboard');
})->middleware(['auth', 'verified'])->name('admin/dashboard');

Route::get('/driver/dashboard', function () {
    return view('driver/dashboard');
})->middleware(['auth', 'verified'])->name('driver/dashboard');

Route::get('/cook/dashboard', function () {
    return view('cook/dashboard');
})->middleware(['auth', 'verified'])->name('cook/dashboard');

Route::get('/customer/dashboard', function () {
    return view('customer/dashboard');
})->middleware(['auth', 'verified'])->name('customer/dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/cook/addFoodItem', function () {
    return view('cook/addFoodItem');
})->middleware(['auth', 'verified'])->name('cook/addFoodItem');

Route::post('/AddFood', [FoodItemController::class, 'store'])->middleware(['auth', 'verified'])->name('AddFood');

Route::get('/customer/foodItems', [FoodItemController::class, 'foodItems'])->middleware(['auth', 'verified'])->name('customer/foodItems');

Route::post('/customer/addToCart', [FoodItemController::class, 'addToCart'])->middleware(['auth', 'verified'])->name('customer/addToCart');

require __DIR__.'/auth.php';
