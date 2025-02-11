<?php

namespace App\Http\Controllers;

use App\Interfaces\AuthInterface;
use App\Interfaces\GoogleCalendarInterface;
use App\Repositories\UserRepository;
use App\Services\GoogleCalendarService;
use Laravel\Socialite\Facades\Socialite;

class GoogleCalendarController extends Controller
{
    protected GoogleCalendarInterface $googleService;
    protected UserRepository $userRepository;
    private AuthInterface $authService;

    public function __construct(GoogleCalendarInterface $googleService, UserRepository $userRepository, AuthInterface $authService)
    {
        $this->googleService = $googleService;
        $this->userRepository = $userRepository;
        $this->authService = $authService;
    }

    public function redirectToGoogle()
    {
        return Socialite::driver('google')
            ->scopes(['profile', 'email', 'https://www.googleapis.com/auth/calendar'])
            ->redirect();
    }

    public function handleGoogleCallback()
    {
        $googleUser = Socialite::driver('google')->user();
        session(['access_token' => $googleUser->token]);
        if (isset($googleUser->refreshToken)) {
            session(['google_refresh_token' => $googleUser->refreshToken]);
        }

        $this->authService->login($googleUser);

        return redirect()->route('dashboard');
    }

}
