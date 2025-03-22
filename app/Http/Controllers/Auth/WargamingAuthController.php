<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class WargamingAuthController extends Controller
{
    public function redirect()
    {
        return Socialite::driver('wargaming')->redirect();
    }
    
    public function callback()
    {
        try {
            $wargamingUser = Socialite::driver('wargaming')->user();
            
            $user = User::updateOrCreate(
                ['wargaming_id' => $wargamingUser->getId()],
                [
                    'name' => $wargamingUser->getName(),
                    'wargaming_token' => $wargamingUser->token,
                ]
            );
            
            Auth::login($user);
            
            return redirect('/dashboard');
        } catch (\Exception $e) {
            return redirect('/login')->withErrors(['error' => 'Došlo je do greške prilikom prijave: ' . $e->getMessage()]);
        }
    }
    
    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }
}