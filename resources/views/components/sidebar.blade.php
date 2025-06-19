<aside class="w-64 bg-white border-r flex-shrink-0">
    <div class="flex flex-col h-full">
        <div class="px-4 py-4 border-b">
            <x-dropdown align="left" width="60">
                <x-slot name="trigger">
                    <button class="w-full flex items-center justify-center gap-2 px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                        <span>New Project</span>
                        <svg class="ml-2 -mr-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" /></svg>
                    </button>
                </x-slot>
                <x-slot name="content">
                    <x-dropdown-link href="#">{{ __('Pengadaan Tanah') }}</x-dropdown-link>
                    <x-dropdown-link href="#">{{ __('ROW') }}</x-dropdown-link>
                </x-slot>
            </x-dropdown>
        </div>

        <div class="flex-1 overflow-y-auto px-4 py-4">
            
            @php
                // Definisikan daftar proyek dan menu di sini agar mudah diubah
                $projects = ['TL Otam - Molibagu', 'TL Marisa - GSM', 'TL Anggrek - Tolinggula'];
                $tahapanSubMenus = ['Sosialisasi', 'Inventaris & Pengumuman', 'Musyawarah', 'Pembayaran'];
                
                // Menu khusus untuk Pengadaan Tanah
                $pengadaanTanahTopMenus = ['Dashboard', 'Perizinan'];
                $pengadaanTanahBottomMenus = ['Dokumen Hasil', 'Sertifikat'];

                // Menu khusus untuk ROW
                $rowTopMenus = ['Dashboard', 'Perizinan'];
                $rowBottomMenus = ['Penetapan Nilai', 'Pembayaran'];
            @endphp

            {{-- BAGIAN 1: PENGADAAN TANAH --}}
            <div>
                <h3 class="px-3 text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Pengadaan Tanah</h3>
                @foreach($projects as $project)
                <details class="mb-2" {{ $loop->first ? 'open' : '' }}>
                    <summary class="cursor-pointer flex items-center justify-between px-3 py-2 rounded-md hover:bg-gray-100">
                        <span class="text-sm font-medium text-gray-800">{{ $project }}</span>
                        <svg class="h-4 w-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                    </summary>
                    <ul class="pl-6 mt-2 space-y-1 text-sm text-gray-700">
                        @foreach($pengadaanTanahTopMenus as $menu)
                        <li><a href="#" class="block px-3 py-1 rounded-md hover:bg-gray-200">{{ $menu }}</a></li>
                        @endforeach
                        <li>
                            <details class="mb-2">
                                <summary class="cursor-pointer flex items-center justify-between px-3 py-1 rounded-md hover:bg-gray-100"><span class="text-sm font-medium">Tahapan</span></summary>
                                <ul class="pl-6 mt-1 space-y-1 text-xs">
                                    @foreach($tahapanSubMenus as $tahapan)
                                    <li><a href="#" class="block px-3 py-1 rounded-md hover:bg-gray-200">{{ $tahapan }}</a></li>
                                    @endforeach
                                </ul>
                            </details>
                        </li>
                        @foreach($pengadaanTanahBottomMenus as $menu)
                        <li><a href="#" class="block px-3 py-1 rounded-md hover:bg-gray-200">{{ $menu }}</a></li>
                        @endforeach
                    </ul>
                </details>
                @endforeach
            </div>

            {{-- Garis Pemisah Visual --}}
            <hr class="my-4 border-gray-200">

            {{-- BAGIAN 2: ROW --}}
            <div>
                 <h3 class="px-3 text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">ROW</h3>
                 @foreach($projects as $project)
                 <details class="mb-2">
                     <summary class="cursor-pointer flex items-center justify-between px-3 py-2 rounded-md hover:bg-gray-100">
                         <span class="text-sm font-medium text-gray-800">{{ $project }}</span>
                         <svg class="h-4 w-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                     </summary>
                     <ul class="pl-6 mt-2 space-y-1 text-sm text-gray-700">
                        @foreach($rowTopMenus as $menu)
                        <li><a href="#" class="block px-3 py-1 rounded-md hover:bg-gray-200">{{ $menu }}</a></li>
                        @endforeach
                        <li>
                            <details class="mb-2">
                                <summary class="cursor-pointer flex items-center justify-between px-3 py-1 rounded-md hover:bg-gray-100"><span class="text-sm font-medium">Tahapan</span></summary>
                                <ul class="pl-6 mt-1 space-y-1 text-xs">
                                    @foreach($tahapanSubMenus as $tahapan)
                                    <li><a href="#" class="block px-3 py-1 rounded-md hover:bg-gray-200">{{ $tahapan }}</a></li>
                                    @endforeach
                                </ul>
                            </details>
                        </li>
                        @foreach($rowBottomMenus as $menu)
                        <li><a href="#" class="block px-3 py-1 rounded-md hover:bg-gray-200">{{ $menu }}</a></li>
                        @endforeach
                    </ul>
                 </details>
                 @endforeach
            </div>
        </div>

        <div class="px-6 py-4 border-t">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <a href="{{ route('logout') }}"
                   class="w-full flex items-center gap-3 px-3 py-2 text-gray-600 rounded-md hover:bg-gray-100 transition"
                   onclick="event.preventDefault(); this.closest('form').submit();">
                    <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M14 8V6C14 4.89543 13.1046 4 12 4H8C6.89543 4 6 4.89543 6 6V18C6 19.1046 6.89543 20 8 20H12C13.1046 20 14 19.1046 14 18V16M10 12H20M20 12L17 9M20 12L17 15" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    Logout
                </a>
            </form>
        </div>
    </div>
</aside>