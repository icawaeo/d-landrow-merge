<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        {{-- AlpineJS Persist Plugin untuk mengingat state sidebar --}}
        <script src="https://cdn.jsdelivr.net/npm/@alpinejs/persist@3.x.x/dist/cdn.min.js"></script>
        
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    
    <body class="font-sans antialiased">
        <div
            x-data="{ sidebarOpen: window.innerWidth > 768 }"
            @resize.window="sidebarOpen = window.innerWidth > 768"
            class="flex h-screen bg-gray-100"
        >

            {{-- KONDISIONAL SIDEBAR (KUNCI UTAMA) --}}
            @auth('admin')
                {{-- Panggil sidebar admin jika yang login adalah admin --}}
                <x-admin-sidebar />
            @else
                {{-- Panggil sidebar user jika bukan admin --}}
                <x-sidebar />
            @endauth

            <div class="flex-1 flex flex-col overflow-hidden">
                <header class="flex justify-between items-center px-6 py-4 bg-white border-b">
                    {{-- Hamburger menu hanya untuk ADMIN dan di layar kecil --}}
                    @auth('admin')
                        <button @click="sidebarOpen = !sidebarOpen" class="sm:hidden text-gray-500 focus:outline-none">
                            <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M4 6h16M4 12h16M4 18h16" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                            </svg>
                        </button>
                    @endauth
                    {{-- Biarkan kosong untuk user atau beri judul --}}
                    <div class="flex-1"></div>

                    {{-- Navigasi (Logout dll) --}}
                    @include('layouts.navigation')
                </header>
                <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-100 p-6">
                    {{ $slot }}
                </main>
            </div>
        </div>
    </body>
</html>