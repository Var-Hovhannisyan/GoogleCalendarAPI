<nav class="bg-gray-800 w-full shadow-xl p-4">
    <div class="container mx-auto flex justify-between items-center">
        <a href="{{ url('/') }}" class="text-xl text-white font-bold">{{ config('app.name', 'Google Calendar') }}</a>
        <div class="text-white">
            @if(session('access_token'))
                <a href="{{ route('dashboard') }}" class="mr-4">Dashboard</a>
                <form method="POST" action="{{ route('logout') }}" class="inline">
                    @csrf
                    <button type="submit" class="text-red-600">Logout</button>
                </form>
            @else
                <a href="{{ url('/auth/google') }}" class="mr-4 p-3 text-center rounded-md bg-blue-600">Continue with
                    Google</a>

            @endif
        </div>
    </div>
</nav>
