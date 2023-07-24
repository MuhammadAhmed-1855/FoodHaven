<?php

namespace App\Http\Controllers\ThirdParty\GoogleAuthentication;

use App\Http\Controllers\Controller;
use Laravel\Socialite\Facades\Socialite;

class RedirectController extends Controller
{
    public function redirect()
    {
        return Socialite::driver('google')->redirect();
    }
}

?>