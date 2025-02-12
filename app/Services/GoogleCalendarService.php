<?php

namespace App\Services;

use App\Interfaces\GoogleCalendarInterface;
use Illuminate\Http\JsonResponse;
use Google\Service\Calendar;
use Google_Client;
use Google_Service_Calendar;

class GoogleCalendarService implements GoogleCalendarInterface
{
    protected Google_Client $client;
    public Calendar $service;

    public function __construct()
    {
        $this->client = new Google_Client();
        $path = storage_path() . '/google/credentials.json';

        if (file_exists($path)) {
            $this->client->setAuthConfig($path);
        }

        $this->client->setAccessType('offline');
        $this->client->setPrompt('select_account consent');
        $this->client->addScope([Google_Service_Calendar::CALENDAR, Google_Service_Calendar::CALENDAR_READONLY]);
    }

    public function setAccessToken($accessToken)
    {
        $this->client->setAccessToken($accessToken);
        $this->service = new Google_Service_Calendar($this->client);
    }


}
