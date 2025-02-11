<?php

namespace App\Interfaces;

interface GoogleCalendarInterface
{
    public function getEvents();
    public function setAccessToken($accessToken);
}
