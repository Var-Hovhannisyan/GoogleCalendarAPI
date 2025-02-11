<?php

namespace App\Services;

use App\Interfaces\AuthInterface;

class AuthService implements AuthInterface
{
    public function login($googleUser) {
        $accessToken = $googleUser->token;
        session(['access_token' => $accessToken]);
        return redirect()->route('dashboard');
    }
}
