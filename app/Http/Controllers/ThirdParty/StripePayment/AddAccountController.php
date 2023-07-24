<?php

namespace App\Http\Controllers\ThirdParty\StripePayment;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Redirect;
use Stripe\Stripe as Stripe;
use Stripe\Account as Account;
use Stripe\StripeClient as Client;

class AddAccountController extends Controller
{
    public function addStripe() {
        echo "Stripe Account";

        $sk = env('SK_STRIPE');
        Stripe::setApiKey($sk);

        $account = Account::create([
            'type' => 'express',
        ]);

        $stripe = new Client($sk);

        $accountLinks = $stripe->accountLinks->create([
            'account' => $account->id,
            'refresh_url' => 'http://127.0.0.1:8000/cook/dashboard',
            'return_url' => 'http://127.0.0.1:8000/cook/success',
            'type' => 'account_onboarding',
        ]);

        $user = User::find(auth()->user()->id);
        $user->stripe_account_id = $account->id;

        $user->save();

        return Redirect::away($accountLinks->url);
    }
}

?>