<?php

namespace App\Services;

use App\Interfaces\EventInterface;
use Google_Client;
use Google_Service_Calendar;
use Google_Service_Calendar_Event;

class EventService implements EventInterface
{
    public function createEvent($data)
    {
        $token = session('access_token');


        $client = new Google_Client();
        $client->setAccessToken($token);
        $service = new Google_Service_Calendar($client);

        $startTime = date('Y-m-d', strtotime($data["start"]));
        $endTime = date('Y-m-d', strtotime($data["end"]));


        $eventData = new Google_Service_Calendar_Event([
            'summary' => $data['summary'],
            'description' => $data['description'],
            'visibility' => 'public',
            'transparency' => 'transparent',
            'sendNotifications' => false,
            'eventType' => 'default',
            'reminders' => ['useDefault' => true],
            'start' => [
                'date' => $startTime,   // Event start date and time
                'timeZone' => 'Asia/Yerevan',      // Adjust the time zone as needed
            ],
            'end' => [
                'date' => $endTime,     // Event end date and time
                'timeZone' => 'Asia/Yerevan',      // Adjust the time zone as needed
            ],
        ]);

        $event = $service->events->insert('primary', $eventData, []);

        return $event->htmlLink;
    }
}
