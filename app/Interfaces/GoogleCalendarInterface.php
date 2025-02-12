<?php

namespace App\Interfaces;

use Illuminate\Http\JsonResponse;

interface GoogleCalendarInterface
{
    public function setAccessToken($accessToken);
}
