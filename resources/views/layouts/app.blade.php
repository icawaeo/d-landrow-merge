<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'D-LANDROW') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <script src="https://cdn.jsdelivr.net/npm/@alpinejs/persist@3.x.x/dist/cdn.min.js"></script>
        
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    
    <body class="font-sans antialiased">
        <div x-data="{ sidebarOpen: window.innerWidth >= 768 }" class="flex h-screen bg-gray-100">

            @auth('admin')
                <x-admin-sidebar />
            @else
                <x-sidebar />
            @endauth

            <div x-show="sidebarOpen" @click="sidebarOpen = false" class="fixed inset-0 z-20 bg-black opacity-50 transition-opacity md:hidden" x-cloak></div>

            <div class="flex-1 flex flex-col overflow-hidden transition-all duration-300 ease-in-out" 
                :class="sidebarOpen ? 'md:ml-64' : 'md:ml-0'">
                @include('layouts.navigation')

                @stack('content-header')

                <main class="flex-1 overflow-x-hidden overflow-y-auto p-6 md:p-8" style="background-color: #e6edee;">
                    {{ $slot }}
                </main>
            </div>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        @stack('scripts')
        
    </body>
</html>