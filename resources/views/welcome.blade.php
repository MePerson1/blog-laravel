<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Blogowansko') }}</title>
        
        <link rel="stylesheet" href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap">

        @vite(['resources/css/app.css'])
    </head>
    <body class="font-sans text-gray-900 antialiased">
        <div class="relative flex items-top justify-center min-h-screen bg-gray-900 sm:items-center py-4 sm:pt-0">
            @if (Route::has('login'))
                <div style ="border: white solid 2px"class="bg-gray-800 rounded hidden fixed px-6 py-4 sm:block">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="text-sm text-gray-500 underline">Menu</a>
                    @else
                        <a href="{{ route('login') }}" class="bg-white text-black font-bold py-2 px-4 rounded">Zaloguj się</a>

                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="ml-4 text-sm text-gray-500 underline">Zarejestruj się</a>
                    @endif
                    @endauth
                </div>
            @endif
    </body>
</html>
