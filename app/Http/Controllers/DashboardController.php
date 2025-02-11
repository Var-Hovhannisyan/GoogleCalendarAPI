<?php

namespace App\Http\Controllers;

use App\Interfaces\GoogleCalendarInterface;

class DashboardController extends Controller
{
    public function events(GoogleCalendarInterface $googleCalendarService) {
        $googleEvents = $googleCalendarService->getEvents();

        $formattedEvents = collect($googleEvents)->map(function ($event) {
            return [
                'title' => $event->getSummary(),
                'start' => $event->getStart()->getDate(),
                'end' => $event->getEnd()->getDate(),
                'description' => $event->getDescription(),
                'location' => $event->getLocation(),
            ];
        })->toArray();

        return view('dashboard', compact('formattedEvents'));
    }
}
