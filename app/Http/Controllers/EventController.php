<?php

namespace App\Http\Controllers;

use App\Interfaces\EventInterface;
use App\Interfaces\GoogleCalendarInterface;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public EventInterface $eventService;
    protected GoogleCalendarInterface $googleCalendarService;

    public function __construct(EventInterface $eventService, GoogleCalendarInterface $googleCalendarService)
    {
        $this->eventService = $eventService;
        $this->googleCalendarService = $googleCalendarService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(EventInterface $eventService)
    {
        $formattedEvents = $eventService->getFormattedEvents();
        return response()->json($formattedEvents);
    }

    public function create(Request $request)
    {
        $data = [
            'summary' => $request->title,
            'description' => $request->description,
            'start' => $request->start_date_time,
            'end' => $request->end_date_time,
            'colorId' => $request->color ? $request->color : null,
        ];
        $this->eventService->createEvent($data);

        return redirect()->route('dashboard');
    }

    public function colors() {
        return $this->eventService->getColorsJson();
    }

    public function edit(Request $request) {
        $event = $this->eventService->getEventById($request->eventId);
        $colors = $this->eventService->getColorsArray();
        return view('events.edit', compact('event', 'colors'));
    }

    public function update(Request $request) {
        $data = [
            'id' => $request->eventId,
            'title' => $request->title,
            'description' => $request->description,
            'start' => $request->start,
            'end' => $request->end,
            'colorId' => $request->colorId ? $request->color : null,
        ];

        $response = $this->eventService->updateEvent($data);
        return redirect()->route('dashboard')->with('message', $response['message']);
    }
}
