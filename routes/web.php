<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\PaymentController;
use Illuminate\Support\Facades\Route;

//Profile Controllers
use App\Http\Controllers\Profile\EditProfileController;
use App\Http\Controllers\Profile\UpdateProfileController;
use App\Http\Controllers\Profile\DestroyProfileController;

//Google Authentication Controllers
use App\Http\Controllers\ThirdParty\GoogleAuthentication\AnalysisController;
use App\Http\Controllers\ThirdParty\GoogleAuthentication\CallbackController;
use App\Http\Controllers\ThirdParty\GoogleAuthentication\RedirectController;
use App\Http\Controllers\ThirdParty\GoogleAuthentication\AddRoleController;

//Food Item Controllers
use App\Http\Controllers\FoodItem\ReturnItemsController;
use App\Http\Controllers\FoodItem\CreateItemController;

//Stripe Payment Controllers
use App\Http\Controllers\ThirdParty\StripePayment\CheckoutController;
use App\Http\Controllers\ThirdParty\StripePayment\AddAccountController;
use App\Http\Controllers\ThirdParty\StripePayment\SuccessController;

//Cart Controllers
use App\Http\Controllers\Cart\AddItemController;
use App\Http\Controllers\Cart\RemoveItemController;
use App\Http\Controllers\Cart\ReturnCartController;

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
    Route::get('/profile', [EditProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [UpdateProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [DestroyProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/cook/addFoodItem', function () {
    return view('cook/addFoodItem');
})->middleware(['auth', 'verified'])->name('cook/addFoodItem');

Route::post('/AddFood', [CreateItemController::class, 'store'])->middleware(['auth', 'verified'])->name('AddFood');

Route::get('/customer/foodItems', [ReturnItemsController::class, 'foodItems'])->middleware(['auth', 'verified'])->name('customer/foodItems');

Route::post('/customer/addToCart', [AddItemController::class, 'addToCart'])->middleware(['auth', 'verified'])->name('customer/addToCart');

Route::get('/customer/cart', [ReturnCartController::class, 'cart'])->middleware(['auth', 'verified'])->name('customer/cart');

Route::post('/customer/removeCartItem', [RemoveItemController::class, 'removeCartItem'])->middleware(['auth', 'verified'])->name('customer/removeCartItem');

Route::get('/customer/payment', [CheckoutController::class, 'checkout'])->middleware(['auth', 'verified'])->name('customer/payment');

Route::get('/customer/success', [SuccessController::class, 'success'])->middleware(['auth', 'verified'])->name('customer/success');

Route::get('/cook/addStripe', [AddAccountController::class, 'addStripe'])->middleware(['auth', 'verified'])->name('cook/addStripe');

Route::get('/cook/success', function () {
    return view('cook/success');
})->middleware(['auth', 'verified'])->name('cook/success');

Route::get('/auth/google/redirect', [RedirectController::class, 'redirect'])->name('auth/google/redirect');

Route::get('/auth/google/callback', [CallbackController::class, 'callback'])->name('auth/google/callback');

Route::get('/role', function() {
    return view('role');
})->name('role');

Route::post('addRole', [AddRoleController::class, 'addRole'])->name('addRole');

Route::get('/admin/analysis', [AnalysisController::class, 'analysis'])->middleware(['auth', 'verified'])->name('admin/analysis');

require __DIR__.'/auth.php';
