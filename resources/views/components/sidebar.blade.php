<aside 
    :class="sidebarOpen ? 'w-64' : 'w-0'"
    class="bg-white border-r flex-shrink-0 transition-all duration-300 ease-in-out overflow-hidden"
>
    <div class="flex flex-col h-full w-64"> 
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
                    <div class="block px-4 py-2 text-xs text-gray-400">{{ __('Pilih Jenis Proyek') }}</div>
                    <x-dropdown-link href="{{ route('pengadaan_tanah.create', ['kategori' => 'pengadaan-tanah']) }}">{{ __('Pengadaan Tanah') }}</x-dropdown-link>
                    <x-dropdown-link href="{{ route('row.create') }}">{{ __('ROW') }}</x-dropdown-link>
                </x-slot>
            </x-dropdown>
        </div>

        @if(Auth::check() && in_array(Auth::user()->role, ['admin1', 'admin2', 'admin3']))
        <div class="px-4 py-4 border-b">
            <a href="{{ route('admin.dashboard') }}" class="w-full flex items-center justify-center gap-2 px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" /></svg>
                <span>Admin Dashboard</span>
            </a>
        </div>
        @endif

        <div class="flex-1 overflow-y-auto px-4 py-4">
            
            @php
                $pengadaanTanahProjects = $daftarPengadaanTanah ?? [];
                $rowProjects = $daftarRow ?? [];
                $pengadaanTanahTopMenus = ['Dashboard', 'Perizinan'];
                $pengadaanTanahTahapan = ['Sosialisasi', 'Inventaris & Pengumuman', 'Musyawarah', 'Pembayaran'];
                $pengadaanTanahMiddleMenus = ['Musyawarah', 'Pembayaran'];
                $pengadaanTanahBottomMenus = ['Dokumen Hasil', 'Sertifikat'];
                $rowTopMenus = ['Dashboard', 'Perizinan'];
                $rowTahapan = ['Sosialisasi', 'Inventaris & Pengumuman', 'Musyawarah', 'Pembayaran'];
                $rowBottomMenus = ['Penetapan Nilai', 'Penyampaian', 'Pembayaran'];
            @endphp

            {{-- BAGIAN 1: PENGADAAN TANAH --}}
            <div>
                <h3 class="px-3 text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Pengadaan Tanah</h3>
                @foreach($pengadaanTanahProjects as $proyek)
                <details class="mb-2" {{ $loop->first ? 'open' : '' }}>
                    <summary class="cursor-pointer flex items-center justify-between px-3 py-2 rounded-md hover:bg-gray-100">
                        <span class="text-sm font-medium text-gray-800">{{ $proyek->nama_proyek }}</span>
                        <svg class="h-4 w-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                    </summary>
                    <ul class="pl-6 mt-2 space-y-1 text-sm text-gray-700">
                        @foreach($pengadaanTanahTopMenus as $menu)
                            @if ($menu === 'Perizinan')
                                <li><a href="{{ route('pengadaan_tanah.perizinan.edit', $proyek->id) }}" class="block px-3 py-1 rounded-md hover:bg-gray-200">{{ $menu }}</a></li>
                            @else
                                <li><a href="#" class="block px-3 py-1 rounded-md hover:bg-gray-200">{{ $menu }}</a></li>
                            @endif
                        @endforeach
                        <li>
                            <details class="mb-2">
                                <summary class="cursor-pointer flex items-center justify-between px-3 py-1 rounded-md hover:bg-gray-100"><span class="text-sm font-medium">Tahapan</span></summary>
                                <ul class="pl-6 mt-1 space-y-1 text-xs">
                                    @foreach($pengadaanTanahTahapan as $tahapan)
                                        @if ($tahapan === 'Sosialisasi')
                                            <li><a href="{{ route('sosialisasi.index', $proyek->id) }}" class="block px-3 py-1 rounded-md hover:bg-gray-200">{{ $tahapan }}</a></li>
                                        @elseif ($tahapan === 'Inventaris & Pengumuman')
                                            <li><a href="{{ route('inventarisasi.index', $proyek->id) }}" class="block px-3 py-1 rounded-md hover:bg-gray-200">{{ $tahapan }}</a></li>
                                        @elseif ($tahapan === 'Musyawarah')
                                             <li><a href="{{ route('musyawarah_sub.index', $proyek->id) }}" class="block px-3 py-1 rounded-md hover:bg-gray-200">{{ $tahapan }}</a></li>
                                        @elseif ($tahapan === 'Pembayaran')
                                             <li><a href="{{ route('pembayaran_sub.index', $proyek->id) }}" class="block px-3 py-1 rounded-md hover:bg-gray-200">{{ $tahapan }}</a></li>                                        
                                        @endif
                                    @endforeach
                                </ul>
                            </details>
                        </li>
                        @foreach($pengadaanTanahMiddleMenus as $menu)
                            @if ($menu === 'Musyawarah')
                                <li><a href="{{ route('musyawarah.index', $proyek->id) }}" class="block px-3 py-1 rounded-md hover:bg-gray-200">{{ $menu }}</a></li>
                            @elseif ($menu === 'Pembayaran')
                                <li><a href="{{ route('pembayaran.index', $proyek->id) }}" class="block px-3 py-1 rounded-md hover:bg-gray-200">{{ $menu }}</a></li>
                            @endif
                        @endforeach
                        @foreach($pengadaanTanahBottomMenus as $menu)
                            @if ($menu === 'Dokumen Hasil')
                                <li><a href="{{ route('dokumenhasil.index', $proyek->id) }}" class="block px-3 py-1 rounded-md hover:bg-gray-200">{{ $menu }}</a></li>
                            @elseif ($menu === 'Sertifikat')
                                <li><a href="{{ route('sertifikat.index', $proyek->id) }}" class="block px-3 py-1 rounded-md hover:bg-gray-200">{{ $menu }}</a></li>
                            @endif
                        @endforeach
                    </ul>
                </details>
                @endforeach
            </div>

            <hr class="my-4 border-gray-200">

            {{-- BAGIAN 2: ROW --}}
            <div>
                 <h3 class="px-3 text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">ROW</h3>
                 @foreach($rowProjects as $proyek)
                 <details class="mb-2">
                       <summary class="cursor-pointer flex items-center justify-between px-3 py-2 rounded-md hover:bg-gray-100">
                           <span class="text-sm font-medium text-gray-800">{{ $proyek->nama_proyek }}</span>
                           <svg class="h-4 w-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                       </summary>
                       <ul class="pl-6 mt-2 space-y-1 text-sm text-gray-700">
                            @foreach($rowTopMenus as $menu)
                                @if ($menu === 'Perizinan')
                                    <li><a href="{{ route('row.perizinan.edit', $proyek->id) }}" class="block px-3 py-1 rounded-md hover:bg-gray-200">{{ $menu }}</a></li>
                                @else
                                    <li><a href="#" class="block px-3 py-1 rounded-md hover:bg-gray-200">{{ $menu }}</a></li>
                                @endif
                            @endforeach
                            <li>
                            <details class="mb-2">
                                <summary class="cursor-pointer flex items-center justify-between px-3 py-1 rounded-md hover:bg-gray-100"><span class="text-sm font-medium">Tahapan</span></summary>
                                <ul class="pl-6 mt-1 space-y-1 text-xs">
                                    @foreach($rowTahapan as $tahapan)
                                        @if ($tahapan === 'Sosialisasi')
                                            <li><a href="{{ route('row.sosialisasi.index', $proyek->id) }}" class="block px-3 py-1 rounded-md hover:bg-gray-200">{{ $tahapan }}</a></li>
                                        @elseif ($tahapan === 'Inventaris & Pengumuman')
                                            <li><a href="{{ route('row-inventarisasi.index', $proyek->id) }}" class="block px-3 py-1 rounded-md hover:bg-gray-200">{{ $tahapan }}</a></li>
                                        @elseif ($tahapan === 'Musyawarah')
                                            <li><a href="{{ route('row.musyawarah_sub.index', $proyek->id) }}" class="block px-3 py-1 rounded-md hover:bg-gray-200">{{ $tahapan }}</a></li>
                                        @elseif ($tahapan === 'Pembayaran')
                                            <li><a href="{{ route('row.pembayaran.index', $proyek->id) }}" class="block px-3 py-1 rounded-md hover:bg-gray-200">{{ $tahapan }}</a></li>
                                        @endif 
                                    @endforeach
                                </ul>
                            </details>
                                  </li>
                            @foreach($rowBottomMenus as $menu)
                                @if ($menu === 'Penetapan Nilai')
                                    <li>
                                    <a href="{{ route('row.penetapan-nilai.index', $proyek->id) }}"
                                            class="block px-3 py-1 rounded-md hover:bg-gray-200">
                                            {{ $menu }}
                                        </a>
                                    </li>
                                @elseif ($menu === 'Penyampaian')
                                    <li>
                                        <a href="{{ route('row.penyampaian.index', $proyek->id) }}" 
                                            class="block px-3 py-1 rounded-md hover:bg-gray-200">
                                            {{ $menu }}
                                        </a>
                                    </li>
                                    @elseif ($menu === 'Pembayaran')
                                        <li>
                                            <a href="{{ route('row.pembayaran-menu.index', $proyek->id) }}"
                                                class="block px-3 py-1 rounded-md hover:bg-gray-200">
                                                {{ $menu }}
                                            </a>
                                        </li>
                                    @endif
                            @endforeach
                       </ul>
                 </details>
                 @endforeach
            </div>
        </div>

        <div class="px-6 py-4 border-t">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <a href="{{ route('logout') }}" class="w-full flex items-center gap-3 px-3 py-2 text-gray-600 rounded-md hover:bg-gray-100 transition" onclick="event.preventDefault(); this.closest('form').submit();">
                    <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M14 8V6C14 4.89543 13.1046 4 12 4H8C6.89543 4 6 4.89543 6 6V18C6 19.1046 6.89543 20 8 20H12C13.1046 20 14 19.1046 14 18V16M10 12H20M20 12L17 9M20 12L17 15" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    Logout
                </a>
            </form>
        </div>
    </div>
</aside>