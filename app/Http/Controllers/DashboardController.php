<?php

namespace App\Http\Controllers;

class DashboardController extends Controller
{
    public function events() {
        return view('dashboard');
    }
}
