<aside
    :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
    class="fixed inset-y-0 left-0 z-30 w-64 bg-gradient-to-b from-slate-800 to-teal-900 text-gray-200 border-r border-slate-700 transform transition-transform duration-300 ease-in-out"
>
    <div class="flex flex-col h-full w-64">
        <div class="px-4 py-4 border-b border-slate-700">
            <x-dropdown align="left" width="60">
                <x-slot name="trigger">
                    <button class="w-full flex items-center justify-center gap-2 px-4 py-2 bg-[#0a4f5e] text-white rounded-md hover:bg-[#083F4B] transition focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-slate-800 focus:ring-white">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                        <span>Proyek Baru</span>
                    </button>
                </x-slot>
                <x-slot name="content">
                    <div class="block px-4 py-2 text-xs text-gray-400 text-left">{{ __('Pilih Jenis Proyek') }}</div>
                    <x-dropdown-link href="{{ route('pengadaan_tanah.create', ['kategori' => 'pengadaan-tanah']) }}">{{ __('Pengadaan Tanah') }}</x-dropdown-link>
                    <x-dropdown-link href="{{ route('row.create') }}">{{ __('ROW') }}</x-dropdown-link>
                </x-slot>
            </x-dropdown>
        </div>

        <div class="flex-1 overflow-y-auto px-4 py-4">

            <div class="md:hidden">
                <ul class="space-y-1">
                    <li>
                        <a href="{{ route('homepage') }}" class="flex items-center gap-3 px-3 py-2 rounded-md transition hover:bg-slate-700 {{ request()->routeIs('homepage') ? 'bg-slate-900' : '' }}">
                            <span class="font-medium text-sm">Beranda</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('profile.edit') }}" class="flex items-center gap-3 px-3 py-2 rounded-md transition hover:bg-slate-700 {{ request()->routeIs('profile.edit') ? 'bg-slate-900' : '' }}">
                            <span class="font-medium text-sm">Profile</span>
                        </a>
                    </li>
                </ul>
                <hr class="my-4 border-slate-700">
            </div>

            <h3 class="px-3 text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2">Pengadaan Tanah</h3>
            <ul class="space-y-1">
                @forelse($pengadaanTanahProjects as $proyek)
                    @php
                        $isProjectActive = request()->is('pengadaan-tanah/'.$proyek->id.'/*') || request()->is('pengadaan-tanah/'.$proyek->id);
                        $canBeModified = $proyek->status_persetujuan === 'belum_diajukan' || str_starts_with($proyek->status_persetujuan, 'ditolak');
                        $currentPengadaanTanah = request()->route('pengadaanTanah');
                        $isCurrentProject = $currentPengadaanTanah && $currentPengadaanTanah->id == $proyek->id;
                        $isTahapanActive = $isCurrentProject && (request()->routeIs('sosialisasi.index') || request()->routeIs('inventarisasi.index') || request()->routeIs('musyawarah_sub.index') || request()->routeIs('pembayaran_sub.index'));
                    @endphp
                    <li x-data="{ projectOpen: {{ $isProjectActive ? 'true' : 'false' }} }">
                        <div class="flex items-center justify-between rounded-md hover:bg-slate-700 {{ $isProjectActive ? 'bg-slate-900' : '' }}">
                            <a @click.prevent="projectOpen = !projectOpen" href="#" title="{{ $proyek->nama_proyek }}" class="flex-grow flex items-center justify-between cursor-pointer pl-3 py-2 pr-2 min-w-0">
                                <span class="text-sm font-medium truncate">{{ $proyek->nama_proyek }}</span>
                            </a>
                            @if($canBeModified)
                            <div class="pr-2">
                                <x-dropdown align="right" width="48">
                                    <x-slot name="trigger">
                                        <button class="p-1 rounded-full text-gray-400 hover:bg-slate-600 hover:text-white focus:outline-none">
                                            <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.75a.75.75 0 110-1.5.75.75 0 010 1.5zM12 12.75a.75.75 0 110-1.5.75.75 0 010 1.5zM12 18.75a.75.75 0 110-1.5.75.75 0 010 1.5z" /></svg>
                                        </button>
                                    </x-slot>
                                    <x-slot name="content">
                                        <x-dropdown-link :href="route('pengadaan_tanah.edit', $proyek->id)">{{ __('Ubah Proyek') }}</x-dropdown-link>
                                        <form class="form-hapus-sidebar" method="POST" action="{{ route('pengadaan_tanah.destroy', $proyek->id) }}" data-nama="{{ $proyek->nama_proyek }}">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="block w-full px-4 py-2 text-left text-sm leading-5 text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition duration-150 ease-in-out">{{ __('Hapus Proyek') }}</button>
                                        </form>
                                    </x-slot>
                                </x-dropdown>
                            </div>
                            @endif
                        </div>
                        
                        <ul x-show="projectOpen" x-transition class="pl-4 mt-2 space-y-1 border-l border-slate-600 ml-3">
                            <li><a href="{{ route('pengadaan_tanah.show', $proyek->id) }}" class="block px-3 py-1 rounded-md hover:bg-slate-700 {{ request()->routeIs('pengadaan_tanah.show', $proyek->id) ? 'bg-slate-700 text-white font-semibold' : 'text-gray-300' }}">Dashboard</a></li>
                            <li><a href="{{ route('pengadaan_tanah.perizinan.edit', $proyek->id) }}" class="block px-3 py-1 rounded-md hover:bg-slate-700 {{ ($isCurrentProject && request()->routeIs('pengadaan_tanah.perizinan.edit')) ? 'bg-slate-700 text-white font-semibold' : 'text-gray-300' }}">Perizinan</a></li>

                            <li x-data="{ tahapanOpen: {{ $isTahapanActive ? 'true' : 'false' }} }">
                                <a @click.prevent="tahapanOpen = !tahapanOpen" href="#" class="flex items-center justify-between w-full px-3 py-1 rounded-md hover:bg-slate-700 cursor-pointer {{ $isTahapanActive ? 'text-white' : 'text-gray-300' }}">
                                    <span>Tahapan</span>
                                    <svg class="h-4 w-4 transform transition-transform" :class="{ 'rotate-180': tahapanOpen }" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                                </a>
                                <ul x-show="tahapanOpen" x-transition class="pl-4 mt-1 space-y-1 text-xs">
                                    <li><a href="{{ route('sosialisasi.index', $proyek->id) }}" class="block px-2 py-1 rounded-md hover:bg-slate-700 {{ $isCurrentProject && request()->routeIs('sosialisasi.index') ? 'bg-slate-700 text-white font-semibold' : 'text-gray-400' }}">Sosialisasi</a></li>
                                    <li><a href="{{ route('inventarisasi.index', $proyek->id) }}" class="block px-2 py-1 rounded-md hover:bg-slate-700 {{ $isCurrentProject && request()->routeIs('inventarisasi.index') ? 'bg-slate-700 text-white font-semibold' : 'text-gray-400' }}">Inventaris & Pengumuman</a></li>
                                    <li><a href="{{ route('musyawarah_sub.index', $proyek->id) }}" class="block px-2 py-1 rounded-md hover:bg-slate-700 {{ $isCurrentProject && request()->routeIs('musyawarah_sub.index') ? 'bg-slate-700 text-white font-semibold' : 'text-gray-400' }}">Musyawarah</a></li>
                                    <li><a href="{{ route('pembayaran_sub.index', $proyek->id) }}" class="block px-2 py-1 rounded-md hover:bg-slate-700 {{ $isCurrentProject && request()->routeIs('pembayaran_sub.index') ? 'bg-slate-700 text-white font-semibold' : 'text-gray-400' }}">Pembayaran</a></li>
                                </ul>
                            </li>
                            <li><a href="{{ route('musyawarah.index', $proyek->id) }}" class="block px-3 py-1 rounded-md hover:bg-slate-700 {{ $isCurrentProject && request()->routeIs('musyawarah.index') ? 'bg-slate-700 text-white font-semibold' : 'text-gray-300' }}">Musyawarah</a></li>
                            <li><a href="{{ route('pembayaran.index', $proyek->id) }}" class="block px-3 py-1 rounded-md hover:bg-slate-700 {{ $isCurrentProject && request()->routeIs('pembayaran.index') ? 'bg-slate-700 text-white font-semibold' : 'text-gray-300' }}">Pembayaran</a></li>
                            <li><a href="{{ route('dokumenhasil.index', ['pengadaanTanah' => $proyek->id]) }}" class="block px-3 py-1 rounded-md hover:bg-slate-700 {{ $isCurrentProject && request()->routeIs('dokumenhasil.index') ? 'bg-slate-700 text-white font-semibold' : 'text-gray-300' }}">Dokumen Hasil</a></li>
                            <li><a href="{{ route('sertifikat.index', $proyek->id) }}" class="block px-3 py-1 rounded-md hover:bg-slate-700 {{ request()->routeIs('sertifikat.index', $proyek->id) ? 'bg-slate-700 text-white font-semibold' : 'text-gray-300' }}">Sertifikat</a></li>
                        </ul>
                    </li>
                @empty
                    <li><p class="px-3 text-sm text-gray-500">Belum ada proyek.</p></li>
                @endforelse
            </ul>

            <hr class="my-4 border-slate-700">

            <h3 class="px-3 text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2">ROW</h3>
            <ul class="space-y-1">
                @forelse($rowProjects as $proyek)
                    @php
                        $isRowProjectActive = request()->is('row/'.$proyek->id.'/*') || request()->is('row/'.$proyek->id);
                        $canBeModified = $proyek->status_persetujuan === 'belum_diajukan' || str_starts_with($proyek->status_persetujuan, 'ditolak');
                        $currentRow = request()->route('row');
                        $isCurrentRowProject = $currentRow && $currentRow->id == $proyek->id;
                        $isRowTahapanActive = $isCurrentRowProject && (request()->routeIs('row.sosialisasi.index') || request()->routeIs('row-inventarisasi.index') || request()->routeIs('row.musyawarah_sub.index') || request()->routeIs('row.pembayaran.index'));
                    @endphp
                    <li x-data="{ projectOpen: {{ $isRowProjectActive ? 'true' : 'false' }} }">
                        <div class="flex items-center justify-between rounded-md hover:bg-slate-700 {{ $isRowProjectActive ? 'bg-slate-900' : '' }}">
                            <a @click.prevent="projectOpen = !projectOpen" href="#" title="{{ $proyek->nama_proyek }}" class="flex-grow flex items-center justify-between cursor-pointer pl-3 py-2 pr-2 min-w-0">
                                <span class="text-sm font-medium truncate">{{ $proyek->nama_proyek }}</span>
                            </a>
                            @if($canBeModified)
                            <div class="pr-2">
                                <x-dropdown align="right" width="48">
                                    <x-slot name="trigger">
                                        <button class="p-1 rounded-full text-gray-400 hover:bg-slate-600 hover:text-white focus:outline-none">
                                            <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.75a.75.75 0 110-1.5.75.75 0 010 1.5zM12 12.75a.75.75 0 110-1.5.75.75 0 010 1.5zM12 18.75a.75.75 0 110-1.5.75.75 0 010 1.5z" /></svg>
                                        </button>
                                    </x-slot>
                                    <x-slot name="content">
                                        <x-dropdown-link :href="route('row.edit', $proyek->id)">{{ __('Ubah Proyek') }}</x-dropdown-link>
                                        <form class="form-hapus-sidebar" method="POST" action="{{ route('row.destroy', $proyek->id) }}" data-nama="{{ $proyek->nama_proyek }}">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="block w-full px-4 py-2 text-left text-sm leading-5 text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition duration-150 ease-in-out">{{ __('Hapus Proyek') }}</button>
                                        </form>
                                    </x-slot>
                                </x-dropdown>
                            </div>
                            @endif
                        </div>
                        
                        <ul x-show="projectOpen" x-transition class="pl-4 mt-2 space-y-1 border-l border-slate-600 ml-3">
                            <li><a href="{{ route('row.show', $proyek->id) }}" class="block px-3 py-1 rounded-md hover:bg-slate-700 {{ request()->routeIs('row.show', $proyek->id) ? 'bg-slate-700 text-white font-semibold' : 'text-gray-300' }}">Dashboard</a></li>
                            <li><a href="{{ route('row.perizinan.edit', $proyek->id) }}" class="block px-3 py-1 rounded-md hover:bg-slate-700 {{ ($isCurrentRowProject && request()->routeIs('row.perizinan.edit')) ? 'bg-slate-700 text-white font-semibold' : 'text-gray-300' }}">Perizinan</a></li>
                            <li x-data="{ tahapanOpen: {{ $isRowTahapanActive ? 'true' : 'false' }} }">
                                <a @click.prevent="tahapanOpen = !tahapanOpen" href="#" class="flex items-center justify-between w-full px-3 py-1 rounded-md hover:bg-slate-700 cursor-pointer {{ $isRowTahapanActive ? 'text-white' : 'text-gray-300' }}">
                                    <span>Tahapan</span>
                                    <svg class="h-4 w-4 transform transition-transform" :class="{ 'rotate-180': tahapanOpen }" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                                </a>
                                <ul x-show="tahapanOpen" x-transition class="pl-4 mt-1 space-y-1 text-xs">
                                    <li><a href="{{ route('row.sosialisasi.index', $proyek->id) }}" class="block px-2 py-1 rounded-md hover:bg-slate-700 {{ $isCurrentRowProject && request()->routeIs('row.sosialisasi.index') ? 'bg-slate-700 text-white font-semibold' : 'text-gray-400' }}">Sosialisasi</a></li>
                                    <li><a href="{{ route('row-inventarisasi.index', $proyek->id) }}" class="block px-2 py-1 rounded-md hover:bg-slate-700 {{ $isCurrentRowProject && request()->routeIs('row-inventarisasi.index') ? 'bg-slate-700 text-white font-semibold' : 'text-gray-400' }}">Inventaris & Pengumuman</a></li>
                                    <li><a href="{{ route('row.musyawarah_sub.index', $proyek->id) }}" class="block px-2 py-1 rounded-md hover:bg-slate-700 {{ $isCurrentRowProject && request()->routeIs('row.musyawarah_sub.index') ? 'bg-slate-700 text-white font-semibold' : 'text-gray-400' }}">Musyawarah</a></li>
                                    <li><a href="{{ route('row.pembayaran.index', $proyek->id) }}" class="block px-2 py-1 rounded-md hover:bg-slate-700 {{ $isCurrentRowProject && request()->routeIs('row.pembayaran.index') ? 'bg-slate-700 text-white font-semibold' : 'text-gray-400' }}">Pembayaran</a></li>
                                </ul>
                            </li>
                            <li><a href="{{ route('row.penetapan-nilai.index', $proyek->id) }}" class="block px-3 py-1 rounded-md hover:bg-slate-700 {{ $isCurrentRowProject && request()->routeIs('row.penetapan-nilai.index') ? 'bg-slate-700 text-white font-semibold' : 'text-gray-300' }}">Penetapan Nilai</a></li>
                            <li><a href="{{ route('row.penyampaian.index', $proyek->id) }}" class="block px-3 py-1 rounded-md hover:bg-slate-700 {{ $isCurrentRowProject && request()->routeIs('row.penyampaian.index') ? 'bg-slate-700 text-white font-semibold' : 'text-gray-300' }}">Penyampaian</a></li>
                            <li><a href="{{ route('row.pembayaran-menu.index', $proyek->id) }}" class="block px-3 py-1 rounded-md hover:bg-slate-700 {{ $isCurrentRowProject && request()->routeIs('row.pembayaran-menu.index') ? 'bg-slate-700 text-white font-semibold' : 'text-gray-300' }}">Pembayaran</a></li>
                        </ul>
                    </li>
                @empty
                    <li><p class="px-3 text-sm text-gray-500">Belum ada proyek.</p></li>
                @endforelse
            </ul>
        </div>

        <div class="px-4 py-4 border-t border-gray-600">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <a href="{{ route('logout') }}" class="w-full flex items-center justify-center gap-3 px-3 py-2 text-gray-300 rounded-md hover:bg-red-900 hover:text-white transition" onclick="event.preventDefault(); this.closest('form').submit();">
                    <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M14 8V6C14 4.89543 13.1046 4 12 4H8C6.89543 4 6 4.89543 6 6V18C6 19.1046 6.89543 20 8 20H12C13.1046 20 14 19.1046 14 18V16M10 12H20M20 12L17 9M20 12L17 15" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    <span class="font-medium">Keluar</span>
                </a>
            </form>
        </div>
    </div>
</aside>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Script untuk konfirmasi hapus proyek dari sidebar
    document.querySelectorAll('.form-hapus-sidebar').forEach(form => {
        form.addEventListener('submit', function (e) {
            e.preventDefault(); 
            let namaProyek = form.getAttribute('data-nama');
            Swal.fire({
                title: 'Hapus Proyek',
                html: `Apakah Anda yakin ingin menghapus proyek <strong>${namaProyek}</strong>? Tindakan ini tidak dapat dibatalkan.`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Ya, Hapus',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });
});
</script>