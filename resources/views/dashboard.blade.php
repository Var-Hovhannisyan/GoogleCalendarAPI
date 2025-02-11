@extends('layout.app')

@section('content')
    <div class="container">
        <h1>Your Google Calendar Events</h1>
        <button id="new-event-btn" class="shadow-md p-2 bg-blue-600 text-white rounded-md">Create event</button>
        <div id="calendar"></div>
    </div>

    <x-modal
        title="Event details"
        deactivateButtonText="Save"
        cancelButtonText="No, Cancel"
    />
@endsection



