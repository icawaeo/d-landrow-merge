<nav x-data="{ open: false }" class="bg-[#0a4f5e] border-b border-teal-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <div class="text-left py-3">
            @auth('admin')
                <a href="{{ route('admin.dashboard') }}">
                    <h1 class="text-white font-bold text-lg tracking-wider uppercase">
                        Sistem Digital ROW & Pengadaan Lahan
                    </h1>
                </a>
            @else
                <a href="{{ route('homepage') }}">
                    <h1 class="text-white font-bold text-lg tracking-wider uppercase">
                        Sistem Digital ROW & Pengadaan Lahan
                    </h1>
                </a>
            @endauth
        </div>

        <hr class="border-t border-teal-700 opacity-60">

        <div class="flex justify-between h-16">
            <div class="flex">
                <div class="shrink-0 flex items-center">
                    {{-- Logo juga mengarah ke dashboard yang sesuai --}}
                    @auth('admin')
                        <a href="{{ route('admin.dashboard') }}">
                            <x-application-logo class="block h-9 w-auto fill-current text-white" />
                        </a>
                    @else
                        <a href="{{ route('homepage') }}">
                            <x-application-logo class="block h-9 w-auto fill-current text-white" />
                        </a>
                    @endauth
                </div>

                <div class="flex items-center ms-4">
                    <button
                        @click="sidebarOpen = !sidebarOpen"
                        class="text-gray-300 hover:text-teal-400 focus:outline-none"
                    >
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                </div>

                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    @auth('web')
                    <x-nav-link :href="route('homepage')" :active="request()->routeIs('homepage')">
                        {{ __('Beranda') }}
                    </x-nav-link>
                    @endauth
                </div>
            </div>

            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-200 hover:text-teal-400 focus:outline-none transition ease-in-out duration-150">
                            {{-- Menampilkan nama user/admin yang sedang login --}}
                            <div>{{ Auth::user()->name }}</div>
                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        @auth('admin')
                            <form method="POST" action="{{ route('admin.logout') }}">
                                @csrf
                                <x-dropdown-link :href="route('admin.logout')"
                                        onclick="event.preventDefault();
                                                    this.closest('form').submit();">
                                    {{ __('Log Out Admin') }}
                                </x-dropdown-link>
                            </form>
                        @else
                            <x-dropdown-link :href="route('profile.edit')">
                                {{ __('Profile') }}
                            </x-dropdown-link>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-dropdown-link :href="route('logout')"
                                        onclick="event.preventDefault();
                                                    this.closest('form').submit();">
                                    {{ __('Log Out') }}
                                </x-dropdown-link>
                            </form>
                        @endauth
                    </x-slot>
                </x-dropdown>
            </div>
        </div>
    </div>
</nav>