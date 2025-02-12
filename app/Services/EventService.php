<?php

namespace App\Services;

use App\Interfaces\EventInterface;
use App\Interfaces\GoogleCalendarInterface;
use Carbon\Carbon;
use Google\Exception;
use Google\Service\Calendar;
use Google_Client;
use Google_Service_Calendar;
use Google_Service_Calendar_Event;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

class EventService implements EventInterface
{
    protected GoogleCalendarInterface $googleCalendarService;
    protected Google_Service_Calendar $service;

    public function __construct(GoogleCalendarService $googleCalendarService)
    {
        $this->googleCalendarService = $googleCalendarService;

        $token = session('access_token');
        if ($token) {
            $this->googleCalendarService->setAccessToken($token);
            $this->service = $this->googleCalendarService->service;
        }
    }

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
            'colorId' => $data['colorId'],
            'start' => [
                'date' => $startTime,   // Event start date and time
                'timeZone' => 'UTC',      // Adjust the time zone as needed
            ],
            'end' => [
                'date' => $endTime,     // Event end date and time
                'timeZone' => 'UTC',      // Adjust the time zone as needed
            ],
        ]);

        $event = $service->events->insert('primary', $eventData);

        return $event->htmlLink;
    }

    public function updateEvent($data)
    {
        try {
            $token = session('access_token');
            $client = new Google_Client();
            $client->setAccessToken($token);
            $service = new Google_Service_Calendar($client);

            if (!isset($data['start']) || !isset($data['end'])) {
                throw new \Exception("Event start or end time is missing.");
            }

            $event = $service->events->get('primary', $data['id']);

            $eventStart = new Calendar\EventDateTime();
            $eventStart->setDateTime(Carbon::parse($data['start'])->toRfc3339String());

            $eventEnd = new Calendar\EventDateTime();
            $eventEnd->setDateTime(Carbon::parse($data['end'])->timezone('UTC')->toRfc3339String());

            $event->setSummary($data['title']);
            $event->setDescription($data['description']);
            $event->setStart($eventStart);
            $event->setEnd($eventEnd);
            $event->setColorId($data['colorId']);

            if (Carbon::parse($data['start'])->greaterThanOrEqualTo(Carbon::parse($data['end']))) {
                throw new \Exception("Event start time must be before end time.");
            }

            $service->events->update('primary', $event->getId(), $event);

            return [
                'data' => $event->getUpdated(),
                'message' => "Event updated successfully!"
            ];
        } catch (Exception $e) {
            Log::error('Google API Error', ['error' => $e->getMessage()]);
            return [
                'data' => null,
                'message' => $e->getMessage()
            ];
        }
    }

    public function deleteEvent($eventId): JsonResponse
    {
        try {
            $accessToken = session('access_token');
            if (!$accessToken) {
                return response()->json(['message' => 'Unauthorized'], 401);
            }
            $this->googleCalendarService->setAccessToken($accessToken);
            $this->service->events->delete('primary', $eventId);
            return response()->json(['message' => 'Event deleted successfully!']);
        } catch (Exception $e) {
            Log::error('Google API Error', ['error' => $e->getMessage()]);
            return response()->json([
                'message' => $e->getMessage()
            ]);
        }

    }

    public function getServiceEvents()
    {
        try {
            $accessToken = session('access_token');
            if (!$accessToken) {
                return redirect()->route('auth.google');
            }
            $this->googleCalendarService->setAccessToken($accessToken);
            $startOfYear = new \DateTime('first day of January this year'); // Start of current year
            $endOfYear = new \DateTime('last day of December this year'); // End of current year

            $events = $this->service->events->listEvents('primary', [
                'orderBy' => 'startTime',
                'singleEvents' => true,
                'timeMin' => $startOfYear->format(\DateTime::RFC3339),
                'timeMax' => $endOfYear->format(\DateTime::RFC3339),
                'eventTypes' => null,
                'timeZone' => 'UTC',
            ]);
            return $events->getItems();
        } catch (Exception $e) {
            return 'Error fetching events: ' . $e->getMessage();
        }
    }

    public function getFormattedEvents(): ?array
    {
        $googleEvents = $this->getServiceEvents();
        return collect($googleEvents)->map(function ($event) {
            return $this->getEventById($event->getId());
        })->toArray();
    }

    public function getEventById($id): ?array
    {
        $event = $this->service->events->get('primary', $id);
        if (empty($event)) {
            return null;
        }
        return [
            'id' => $event->getId(),
            'title' => $event->getSummary(),
            'start' => Carbon::parse($event->getStart()->getDate() ?? $event->getStart()->getDateTime())->timezone('UTC')->toRfc3339String(),
            'end' => Carbon::parse($event->getEnd()->getDate() ?? $event->getEnd()->getDateTime())->timezone('UTC')->toRfc3339String(),
            'description' => $event->getDescription(),
            'location' => $event->getLocation(),
            'color' => $this->getEventColor($event->getColorId()),
        ];
    }

    public function getEventColor($colorId): ?string
    {
        if (!$colorId) {
            return '#3788d8'; // Default color if no color is assigned
        }

        $serviceColors = $this->service->colors->get();
        $eventColors = $serviceColors->getEvent();

        return $eventColors[$colorId]['background'] ?? '#3788d8'; // Fallback color
    }


    private function getColors(): array
    {
        $colors = $this->service->colors->get()->getEvent(); // Fetch event colors

        $formattedColors = [];
        foreach ($colors as $colorId => $color) {
            $formattedColors[] = [
                'id' => $colorId,
                'background' => $color['background'],
            ];
        }

        return $formattedColors;
    }

    public function getColorsJson(): JsonResponse
    {
        return response()->json($this->getColors());
    }

    public function getColorsArray(): array
    {
        return $this->getColors();
    }
}
