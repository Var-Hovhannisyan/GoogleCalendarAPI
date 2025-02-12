@extends('layout.app')

@section('content')
    <div class="p-6 bg-white shadow-md max-w-xl mx-auto rounded-lg flex items-center flex-col">
        <div class="flex justify-between w-full">
            <h1 class="text-2xl self-start font-bold"><span class="text-blue-600">{{$event['title']}}</span></h1>
            <form action="{{route('events.delete', ['eventId' => $event['id']] )}}" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit" class="bg-red-500 hover:bg-red-400 text-white font-bold py-2 px-4 border-b-4 border-red-700 hover:border-red-500 rounded">
                    Delete
                </button>
            </form>

        </div>
        <form action="{{ route('events.update', ['eventId' => $event['id']]) }}" method="POST" class="w-full max-w-lg">
            @csrf
            @method('PUT')
            <div class="flex flex-col w-full gap-2 items-center flex-wrap mx-3 my-6">
                <div class="w-full mb-6 md:mb-0">
                    <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
                           for="grid-event-title">
                        Event title
                    </label>
                    <input
                        name="title"
                        class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white"
                        id="grid-event-title" type="text" value="{{$event['title']}}">
                </div>
                <div class="w-full">
                    <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
                           for="grid-event-description">
                        Event description
                    </label>
                    <textarea
                        rows="4"
                        name="description"
                        class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                        id="grid-event-description">{{$event['description']}}</textarea>
                </div>
            </div>
            <div class="flex flex-wrap justify-center mx-3 my-2">
                <div class="w-full  mb-6 md:mb-0">
                    <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="grid-state">
                        Event color
                    </label>
                    <div class="relative">
                        <select
                            name="colorId"
                            class="block appearance-none w-full bg-gray-200 border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                            id="grid-state">
                            @foreach($colors as $color)
                                <option value="{{$color['id']}}"
                                        @if($color['background'] == $event['color']) selected @endif
                                        style="background-color: {{$color['background']}}">{{$color['background']}}</option>
                            @endforeach
                        </select>
                        <div
                            class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                            <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
            <div class="flex w-full justify-center mx-3 my-6">
                <div class="w-full  px-1">
                    <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
                           for="grid-event-start-time">
                        Start time
                    </label>
                    <input value="{{ \Carbon\Carbon::parse($event['start'])->format('Y-m-d\TH:i') }}"
                           name="start"
                           class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white"
                           id="grid-event-start-time" type="datetime-local"/>
                </div>
                <div class="w-full  px-1">
                    <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
                           for="grid-event-end-time">
                        End time
                    </label>
                    <input value="{{ \Carbon\Carbon::parse($event['end'])->format('Y-m-d\TH:i') }}"
                           name="end"
                           class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white"
                           id="grid-event-end-time" type="datetime-local"/>
                </div>
            </div>
            <div class="flex justify-between gap-2 py-2 px-3 my-3">
                <a href="{{ route('dashboard') }}"
                   class="bg-white text-center w-full hover:bg-gray-100 text-gray-800 font-semibold py-2 px-4 border border-gray-400 rounded shadow">
                    Cancel
                </a>
                <button
                    type="submit"
                    class="bg-blue-500 w-full hover:bg-blue-400 text-white font-bold py-2 px-4 border-b-4 border-blue-700 hover:border-blue-500 rounded">
                    Save
                </button>
            </div>
        </form>
    </div>
@endsection
