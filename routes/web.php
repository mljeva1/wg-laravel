<?php

use Illuminate\Support\Facades\Route;

// Početna stranica
Route::get('/', function () {
    return view('welcome');
});

// Redirekcija na Wargaming login
Route::get('/auth/wargaming', function () {
    $applicationId = env('WARGAMING_APPLICATION_ID');
    $redirectUri = env('WARGAMING_REDIRECT_URI');
    $loginUrl = "https://api.worldoftanks.eu/wot/auth/login/?application_id={$applicationId}&redirect_uri={$redirectUri}";

    return redirect($loginUrl);
})->name('wargaming.login');

// Obrada povratnih podataka nakon prijave
Route::get('/auth/wargaming/callback', function (Illuminate\Http\Request $request) {
    $status = $request->query('status');

    if (!$status) {
        return redirect('/')->withErrors(['error' => 'Status nije dostavljen.']);
    }

    if ($status === 'ok') {
        // Uspješna autentikacija - spremanje podataka u sesiju
        session([
            'access_token' => $request->query('access_token'),
            'expires_at' => $request->query('expires_at'),
            'account_id' => $request->query('account_id'),
            'nickname' => $request->query('nickname'),
        ]);

        return redirect('/dashboard')->with('success', "Dobrodošli, {$request->query('nickname')}!");
    } elseif ($status === 'error') {
        // Greška prilikom autentikacije
        return redirect('/')->withErrors([
            'error' => "Greška ({$request->query('code')}): {$request->query('message')}"
        ]);
    }

    return redirect('/')->withErrors(['error' => 'Nepoznata greška.']);
});

// Dashboard - samo za prijavljene korisnike
Route::get('/dashboard', function () {
    if (!session()->has('nickname')) {
        return redirect('/')->withErrors(['error' => 'Niste prijavljeni.']);
    }

    return view('dashboard', [
        'nickname' => session('nickname'),
        'account_id' => session('account_id'),
        'player' => session('players')
    ]);
})->name('dashboard');