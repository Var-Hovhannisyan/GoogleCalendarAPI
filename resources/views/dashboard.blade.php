@extends('layout.app')

@section('content')
        <h1>Your Google Calendar Events</h1>
        <button id="new-event-btn" class="shadow-md p-2 bg-blue-600 text-white rounded-md">Create event</button>
        <div id="calendar" class="w-full"></div>
    <x-modal
        id="new-event"
        title="New Event"
        deactivateButtonText="Save"
        cancelButtonText="No, Cancel"
    />
@endsection



