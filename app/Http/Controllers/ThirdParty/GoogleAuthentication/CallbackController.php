<?php

namespace App\Http\Controllers\ThirdParty\GoogleAuthentication;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class CallbackController extends Controller
{
    public function callback()
    {
        try {
            $google_user = Socialite::driver('google')->user();
            $user = User::where('google_id', $google_user->getId())->first();

            if(!$user) {
                $user = User::create([
                    'name' => $google_user->getName(),
                    'email' => $google_user->getEmail(),
                    'google_id' => $google_user->getId(),
                ]);
                event(new Registered($user));
                return view('role')->with(compact('user'));
            }
            else {

                Auth::login($user);

                if($user->hasRole('customer') == 1) {
                    return redirect()->intended(RouteServiceProvider::HOME_CUSTOMER);
                }
                else if($user->hasRole('cook') == 1) {
                    return redirect()->intended(RouteServiceProvider::HOME_COOK);
                }
                else if($user->hasRole('driver') == 1) {
                    return redirect()->intended(RouteServiceProvider::HOME_DRIVER);
                }
            }
        }
        catch (\Exception $e) {
            dd($e->getMessage());
        }
    }
}

?>