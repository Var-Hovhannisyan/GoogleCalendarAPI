<?php

namespace App\Http\Controllers;

use App\Interfaces\EventInterface;
use App\Interfaces\GoogleCalendarInterface;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public EventInterface $eventService;

    public function __construct(EventInterface $eventService)
    {
        $this->eventService = $eventService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(GoogleCalendarInterface $googleCalendarService)
    {
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

        return response()->json($formattedEvents);
    }

    public function create(Request $request)
    {
        $data = [
            'summary' => $request->title,
            'description' => $request->description,
            'start' => $request->start_date_time,
            'end' => $request->end_date_time,
        ];
        $this->eventService->createEvent($data);

        return redirect()->route('dashboard');
    }
}
