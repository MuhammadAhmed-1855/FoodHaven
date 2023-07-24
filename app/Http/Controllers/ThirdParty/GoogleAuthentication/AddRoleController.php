<?php

namespace App\Http\Controllers\ThirdParty\GoogleAuthentication;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AddRoleController extends Controller
{
    public function addRole(Request $req)
    {
        $id = $req->id;
        $role =  $req->role;

        $user = User::find($id);

        if($role == 'driver') {
            $user->assignRole('driver');
            $user->update();
            Auth::login($user);
    
            return redirect(RouteServiceProvider::HOME_DRIVER);
        }

        elseif($role == 'customer') {
            $user->assignRole('customer');
            $user->update();
            Auth::login($user);
    
            return redirect(RouteServiceProvider::HOME_CUSTOMER);
        }

        elseif($role == 'cook') {
            $user->assignRole('cook');
            $user->update();
            Auth::login($user);
    
            return redirect(RouteServiceProvider::HOME_COOK);
        }
    }
}

?>