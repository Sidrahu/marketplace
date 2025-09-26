<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net" />
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="font-sans antialiased bg-gray-100">

    @php $user = auth()->user(); @endphp

    <div class="flex min-h-screen">

        {{-- Seller Sidebar --}}
        @if($user && $user->hasRole('seller'))
            @include('layouts.seller-sidebar')
        @endif

        {{-- Buyer Sidebar --}}
        @if($user && $user->hasRole('buyer'))
            @include('layouts.buyer-sidebar')
        @endif

         @if($user && $user->hasRole('admin'))
            @include('layouts.admin-sidebar')
        @endif

        <div class="flex-grow flex flex-col">
            <livewire:layout.navigation />

            {{-- Header --}}
            @if (isset($header))
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endif

            {{-- Main Content --}}
            <main class="flex-grow p-6 overflow-auto">
                {{ $slot }}
            </main>
        </div>
    </div>

    @livewireScripts
</body>
</html>
