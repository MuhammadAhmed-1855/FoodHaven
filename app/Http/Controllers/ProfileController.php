<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Laravel\Socialite\Facades\Socialite;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use Illuminate\Support\Facades\Session;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }

    public function userList()
    {
        $users = User::all();
        return view('admin/userList', compact('users'));
    }
    
    public function redirect() {
        return Socialite::driver('google')->redirect();
    }

    public function callback() {
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

    public function addRole(Request $req) {
        $id = $req->id;
        $role =  $req->role;

        $user = User::find($id);

        if($role == 'driver')
        {
            $user->assignRole('driver');
            $user->update();
            Auth::login($user);
    
            return redirect(RouteServiceProvider::HOME_DRIVER);
        }
        elseif($role == 'customer')
        {
            $user->assignRole('customer');
            $user->update();
            Auth::login($user);
    
            return redirect(RouteServiceProvider::HOME_CUSTOMER);
        }
        elseif($role == 'cook')
        {
            $user->assignRole('cook');
            $user->update();
            Auth::login($user);
    
            return redirect(RouteServiceProvider::HOME_COOK);
        }
    }
}
