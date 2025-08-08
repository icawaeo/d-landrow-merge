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

        <div class="flex-1 overflow-y-auto px-4 py-4">

            <h3 class="px-3 text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Pengadaan Tanah</h3>
            <ul class="space-y-2">
                @forelse($pengadaanTanahProjects as $proyek)
                    @php
                        $isProjectActive = request()->is('pengadaan-tanah/'.$proyek->id.'/*') || request()->is('pengadaan-tanah/'.$proyek->id);
                        $isTahapanActive = request()->routeIs('sosialisasi.index', $proyek->id) || request()->routeIs('inventarisasi.index', $proyek->id) || request()->routeIs('musyawarah_sub.index', $proyek->id) || request()->routeIs('pembayaran_sub.index', $proyek->id);
                    @endphp
                    <li x-data="{ projectOpen: {{ $isProjectActive ? 'true' : 'false' }} }">
                        <a @click.prevent="projectOpen = !projectOpen" href="#" class="flex items-center justify-between px-3 py-2 rounded-md hover:bg-gray-100 cursor-pointer {{ $isProjectActive ? 'bg-gray-100' : '' }}">
                            <span class="text-sm font-medium text-gray-800 truncate">{{ $proyek->nama_proyek }}</span>
                            <svg class="h-4 w-4 text-gray-400 transform transition-transform" :class="{ 'rotate-180': projectOpen }" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                        </a>
                        <ul x-show="projectOpen" x-transition class="pl-4 mt-2 space-y-1 text-sm text-gray-700 border-l-2 border-gray-100 ml-2">
                            <li><a href="{{ route('pengadaan_tanah.show', $proyek->id) }}" class="block px-3 py-1 rounded-md hover:bg-gray-200 {{ request()->routeIs('pengadaan_tanah.show', $proyek->id) ? 'bg-blue-100 text-blue-700 font-semibold' : '' }}">Dashboard</a></li>
                            <li><a href="{{ route('pengadaan_tanah.perizinan.edit', $proyek->id) }}" class="block px-3 py-1 rounded-md hover:bg-gray-200 {{ request()->routeIs('pengadaan_tanah.perizinan.edit', $proyek->id) ? 'bg-blue-100 text-blue-700 font-semibold' : '' }}">Perizinan</a></li>

                            <li x-data="{ tahapanOpen: {{ $isTahapanActive ? 'true' : 'false' }} }">
                                <a @click.prevent="tahapanOpen = !tahapanOpen" href="#" class="flex items-center justify-between block px-3 py-1 rounded-md hover:bg-gray-200 cursor-pointer {{ $isTahapanActive ? 'bg-gray-200' : '' }}">
                                    <span>Tahapan</span>
                                    <svg class="h-4 w-4 transform transition-transform" :class="{ 'rotate-180': tahapanOpen }" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                                </a>
                                <ul x-show="tahapanOpen" x-transition class="pl-4 mt-1 space-y-1 text-xs">
                                    <li><a href="{{ route('sosialisasi.index', $proyek->id) }}" class="block px-2 py-1 rounded-md hover:bg-gray-200 {{ request()->routeIs('sosialisasi.index', $proyek->id) ? 'bg-blue-100 text-blue-700 font-semibold' : '' }}">Sosialisasi</a></li>
                                    <li><a href="{{ route('inventarisasi.index', $proyek->id) }}" class="block px-2 py-1 rounded-md hover:bg-gray-200 {{ request()->routeIs('inventarisasi.index', $proyek->id) ? 'bg-blue-100 text-blue-700 font-semibold' : '' }}">Inventaris & Pengumuman</a></li>
                                    <li><a href="{{ route('musyawarah_sub.index', $proyek->id) }}" class="block px-2 py-1 rounded-md hover:bg-gray-200 {{ request()->routeIs('musyawarah_sub.index', $proyek->id) ? 'bg-blue-100 text-blue-700 font-semibold' : '' }}">Musyawarah</a></li>
                                    <li><a href="{{ route('pembayaran_sub.index', $proyek->id) }}" class="block px-2 py-1 rounded-md hover:bg-gray-200 {{ request()->routeIs('pembayaran_sub.index', $proyek->id) ? 'bg-blue-100 text-blue-700 font-semibold' : '' }}">Pembayaran</a></li>
                                </ul>
                            </li>
                            
                            <li><a href="{{ route('musyawarah.index', $proyek->id) }}" class="block px-3 py-1 rounded-md hover:bg-gray-200 {{ request()->routeIs('musyawarah.index', $proyek->id) ? 'bg-blue-100 text-blue-700 font-semibold' : '' }}">Musyawarah</a></li>
                            <li><a href="{{ route('pembayaran.index', $proyek->id) }}" class="block px-3 py-1 rounded-md hover:bg-gray-200 {{ request()->routeIs('pembayaran.index', $proyek->id) ? 'bg-blue-100 text-blue-700 font-semibold' : '' }}">Pembayaran</a></li>
                            <li><a href="{{ route('dokumenhasil.index', ['pengadaanTanah' => $proyek->id]) }}" class="block px-3 py-1 rounded-md hover:bg-gray-200 {{ request()->routeIs('dokumenhasil.index') ? 'bg-blue-100 text-blue-700 font-semibold' : '' }}">Dokumen Hasil</a></li>
                            <li><a href="{{ route('sertifikat.index', $proyek->id) }}" class="block px-3 py-1 rounded-md hover:bg-gray-200 {{ request()->routeIs('sertifikat.index', $proyek->id) ? 'bg-blue-100 text-blue-700 font-semibold' : '' }}">Sertifikat</a></li>
                        </ul>
                    </li>
                @empty
                    <li><p class="px-3 text-sm text-gray-400">Belum ada proyek.</p></li>
                @endforelse
            </ul>

            <hr class="my-4 border-gray-200">

            <h3 class="px-3 text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">ROW</h3>
            <ul class="space-y-2">
                @forelse($rowProjects as $proyek)
                     @php
                        $isRowProjectActive = request()->is('row/'.$proyek->id.'/*') || request()->is('row/'.$proyek->id);
                        $isRowTahapanActive = request()->routeIs('row.sosialisasi.index', $proyek->id) || request()->routeIs('row-inventarisasi.index', $proyek->id) || request()->routeIs('row.musyawarah_sub.index', $proyek->id) || request()->routeIs('row.pembayaran.index', $proyek->id);
                    @endphp
                    <li x-data="{ projectOpen: {{ $isRowProjectActive ? 'true' : 'false' }} }">
                        <a @click.prevent="projectOpen = !projectOpen" href="#" class="flex items-center justify-between px-3 py-2 rounded-md hover:bg-gray-100 cursor-pointer {{ $isRowProjectActive ? 'bg-gray-100' : '' }}">
                            <span class="text-sm font-medium text-gray-800 truncate">{{ $proyek->nama_proyek }}</span>
                            <svg class="h-4 w-4 text-gray-400 transform transition-transform" :class="{ 'rotate-180': projectOpen }" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                        </a>
                        <ul x-show="projectOpen" x-transition class="pl-4 mt-2 space-y-1 text-sm text-gray-700 border-l-2 border-gray-100 ml-2">
                            <li><a href="{{ route('row.show', $proyek->id) }}" class="block px-3 py-1 rounded-md hover:bg-gray-200 {{ request()->routeIs('row.show', $proyek->id) ? 'bg-blue-100 text-blue-700 font-semibold' : '' }}">Dashboard</a></li>
                            <li><a href="{{ route('row.perizinan.edit', $proyek->id) }}" class="block px-3 py-1 rounded-md hover:bg-gray-200 {{ request()->routeIs('row.perizinan.edit', $proyek->id) ? 'bg-blue-100 text-blue-700 font-semibold' : '' }}">Perizinan</a></li>
                             <li x-data="{ tahapanOpen: {{ $isRowTahapanActive ? 'true' : 'false' }} }">
                                <a @click.prevent="tahapanOpen = !tahapanOpen" href="#" class="flex items-center justify-between block px-3 py-1 rounded-md hover:bg-gray-200 cursor-pointer {{ $isRowTahapanActive ? 'bg-gray-200' : '' }}">
                                    <span>Tahapan</span>
                                    <svg class="h-4 w-4 transform transition-transform" :class="{ 'rotate-180': tahapanOpen }" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                                </a>
                                <ul x-show="tahapanOpen" x-transition class="pl-4 mt-1 space-y-1 text-xs">
                                    <li><a href="{{ route('row.sosialisasi.index', $proyek->id) }}" class="block px-2 py-1 rounded-md hover:bg-gray-200 {{ request()->routeIs('row.sosialisasi.index', $proyek->id) ? 'bg-blue-100 text-blue-700 font-semibold' : '' }}">Sosialisasi</a></li>
                                    <li><a href="{{ route('row-inventarisasi.index', $proyek->id) }}" class="block px-2 py-1 rounded-md hover:bg-gray-200 {{ request()->routeIs('row-inventarisasi.index', $proyek->id) ? 'bg-blue-100 text-blue-700 font-semibold' : '' }}">Inventaris & Pengumuman</a></li>
                                    <li><a href="{{ route('row.musyawarah_sub.index', $proyek->id) }}" class="block px-2 py-1 rounded-md hover:bg-gray-200 {{ request()->routeIs('row.musyawarah_sub.index', $proyek->id) ? 'bg-blue-100 text-blue-700 font-semibold' : '' }}">Musyawarah</a></li>
                                    <li><a href="{{ route('row.pembayaran.index', $proyek->id) }}" class="block px-2 py-1 rounded-md hover:bg-gray-200 {{ request()->routeIs('row.pembayaran.index', $proyek->id) ? 'bg-blue-100 text-blue-700 font-semibold' : '' }}">Pembayaran</a></li>
                                </ul>
                            </li>
                            <li><a href="{{ route('row.penetapan-nilai.index', $proyek->id) }}" class="block px-3 py-1 rounded-md hover:bg-gray-200 {{ request()->routeIs('row.penetapan-nilai.index', $proyek->id) ? 'bg-blue-100 text-blue-700 font-semibold' : '' }}">Penetapan Nilai</a></li>
                            <li><a href="{{ route('row.penyampaian.index', $proyek->id) }}" class="block px-3 py-1 rounded-md hover:bg-gray-200 {{ request()->routeIs('row.penyampaian.index', $proyek->id) ? 'bg-blue-100 text-blue-700 font-semibold' : '' }}">Penyampaian</a></li>
                            <li><a href="{{ route('row.pembayaran-menu.index', $proyek->id) }}" class="block px-3 py-1 rounded-md hover:bg-gray-200 {{ request()->routeIs('row.pembayaran-menu.index', $proyek->id) ? 'bg-blue-100 text-blue-700 font-semibold' : '' }}">Pembayaran</a></li>
                        </ul>
                    </li>
                @empty
                    <li><p class="px-3 text-sm text-gray-400">Belum ada proyek.</p></li>
                @endforelse
            </ul>
        </div>

        <div class="px-6 py-4 border-t">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <a href="{{ route('logout') }}" class="w-full flex items-center justify-center gap-3 px-3 py-2 text-gray-600 rounded-md hover:bg-gray-100 transition" onclick="event.preventDefault(); this.closest('form').submit();">
                    <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M14 8V6C14 4.89543 13.1046 4 12 4H8C6.89543 4 6 4.89543 6 6V18C6 19.1046 6.89543 20 8 20H12C13.1046 20 14 19.1046 14 18V16M10 12H20M20 12L17 9M20 12L17 15" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    <span class="font-medium">Logout</span>
                </a>
            </form>
        </div>
    </div>
</aside>