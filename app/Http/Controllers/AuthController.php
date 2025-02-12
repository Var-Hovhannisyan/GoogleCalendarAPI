<?php

namespace App\Http\Controllers;

class AuthController extends Controller
{
    public function logout () {
        session(['access_token' => null]);
        return redirect('/');
    }
}
