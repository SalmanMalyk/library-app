<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.png') }}">
        <title inertia>{{ config('app.name', 'Library') }}</title>
        @vite(['resources/js/app.js', 'resources/css/app.scss'])
    </head>
    <body>
        <x-partials.navbar />
        
        <div class="container">
            <div class="mt-5">
                @yield('content')
            </div>
        </div>
    </body>
</html>
