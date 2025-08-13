<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('SISTEM DIGITAL ROW & PENGADAAN LAHAN') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            
            <div class="relative bg-gradient-to-r from-cyan-500 to-blue-600 rounded-lg shadow-lg overflow-hidden">
                <div class="absolute inset-0 bg-black opacity-20"></div>
                <div class="relative p-8 flex items-center justify-between">
                    <div class="max-w-xl">
                        <h3 class="text-2xl font-bold text-white">Selamat Datang, {{ Str::words(Auth::user()->name, 2, '') }}!</h3>
                        <p class="text-sm text-blue-100 mt-2">
                            Kelola semua data proyek Pengadaan Tanah dan ROW disini. 
                        </p>
                    </div>
                    <div class="hidden md:block">
                        <img src="{{ asset('images/icon-tower.png') }}" alt="Tower Icon" class="w-32 h-32 opacity-90" />
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Proyek Pengadaan Tanah</h3>
                    <div class="overflow-x-auto">
                        <table class="min-w-full bg-white">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Proyek</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Lokasi</th>
                                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @forelse($daftarPengadaanTanah as $proyek)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900">{{ $proyek->nama_proyek }}</div>
                                        <div class="text-sm text-gray-500">{{ $proyek->jumlah_tower }} Tower</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $proyek->desa }}, {{ $proyek->kecamatan }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center">
                                        @php
                                            $status = $proyek->status_persetujuan;
                                            $statusText = 'Belum Diajukan';
                                            $statusColor = 'bg-gray-100 text-gray-800';
                                            if ($status === 'disetujui') {
                                                $statusText = 'Disetujui';
                                                $statusColor = 'bg-green-100 text-green-800';
                                            } elseif (str_starts_with($status, 'ditolak')) {
                                                $statusText = 'Ditolak';
                                                $statusColor = 'bg-red-100 text-red-800';
                                            } elseif (str_starts_with($status, 'menunggu')) {
                                                $statusText = 'Menunggu Persetujuan';
                                                $statusColor = 'bg-yellow-100 text-yellow-800';
                                            }
                                        @endphp
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $statusColor }}">
                                            {{ $statusText }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <div class="flex items-center justify-center gap-2">
                                            @if($proyek->status_persetujuan === 'belum_diajukan' || str_starts_with($proyek->status_persetujuan, 'ditolak'))
                                                {{-- <a href="{{ route('pengadaan_tanah.edit', $proyek->id) }}" class="px-2 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700" title="Ubah">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 4H6a2 2 0 00-2 2v12a2 2 0 002 2h12a2 2 0 002-2v-5M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                                                </a>
                                                <form class="form-hapus" action="{{ route('pengadaan_tanah.destroy', $proyek->id) }}" method="POST" data-nama="{{ $proyek->nama_proyek }}">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="px-2 py-2 bg-red-600 text-white rounded-md hover:bg-red-700" title="Hapus">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6M9 7h6m2 0a2 2 0 00-2-2H9a2 2 0 00-2 2h10z" /></svg>
                                                    </button>
                                                </form> --}}
                                                <form action="{{ route('pengadaan-tanah.ajukan', $proyek->id) }}" method="POST" class="form-ajukan" data-nama="{{ $proyek->nama_proyek }}">
                                                    @csrf
                                                    <button type="submit" class="px-3 py-2 bg-blue-600 text-white text-xs font-semibold rounded-md hover:bg-blue-700">Ajukan</button>
                                                </form>
                                            @endif
                                            @if(str_starts_with($proyek->status_persetujuan, 'ditolak') && $proyek->catatan_penolakan)
                                                <button type="button" 
                                                        class="lihat-catatan px-3 py-2 bg-yellow-400 text-yellow-800 text-xs font-semibold rounded-md hover:bg-yellow-500"
                                                        data-catatan="{{ $proyek->catatan_penolakan }}">
                                                    Lihat Catatan
                                                </button>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-4 text-center text-gray-500">Belum ada data Pengadaan Tanah.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Proyek ROW</h3>
                    <div class="overflow-x-auto">
                        <table class="min-w-full bg-white">
                             <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Proyek</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Lokasi</th>
                                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @forelse($daftarRow as $proyek)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium text-gray-900">{{ $proyek->nama_proyek }}</div>
                                            <div class="text-sm text-gray-500">{{ $proyek->jumlah_tower }} Tower</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $proyek->desa }}, {{ $proyek->kecamatan }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-center">
                                            @php
                                                $status = $proyek->status_persetujuan;
                                                $statusText = 'Belum Diajukan';
                                                $statusColor = 'bg-gray-100 text-gray-800';
                                                if ($status === 'disetujui') {
                                                    $statusText = 'Disetujui';
                                                    $statusColor = 'bg-green-100 text-green-800';
                                                } elseif (str_starts_with($status, 'ditolak')) {
                                                    $statusText = 'Ditolak';
                                                    $statusColor = 'bg-red-100 text-red-800';
                                                } elseif (str_starts_with($status, 'menunggu')) {
                                                    $statusText = 'Menunggu Persetujuan';
                                                    $statusColor = 'bg-yellow-100 text-yellow-800';
                                                }
                                            @endphp
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $statusColor }}">
                                                {{ $statusText }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <div class="flex items-center justify-center gap-2">
                                                @if($proyek->status_persetujuan === 'belum_diajukan' || str_starts_with($proyek->status_persetujuan, 'ditolak'))
                                                    {{-- <a href="{{ route('row.edit', $proyek->id) }}" class="px-2 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700" title="Ubah">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 4H6a2 2 0 00-2 2v12a2 2 0 002 2h12a2 2 0 002-2v-5M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                                                    </a>
                                                    <form class="form-hapus" action="{{ route('row.destroy', $proyek->id) }}" method="POST" data-nama="{{ $proyek->nama_proyek }}">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="px-2 py-2 bg-red-600 text-white rounded-md hover:bg-red-700" title="Hapus">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6M9 7h6m2 0a2 2 0 00-2-2H9a2 2 0 00-2 2h10z" /></svg>
                                                        </button>
                                                    </form> --}}
                                                    <form action="{{ route('row.ajukan', $proyek->id) }}" method="POST" class="form-ajukan" data-nama="{{ $proyek->nama_proyek }}">
                                                        @csrf
                                                        <button type="submit" class="px-3 py-2 bg-blue-600 text-white text-xs font-semibold rounded-md hover:bg-blue-700">Ajukan</button>
                                                    </form>
                                                @endif
                                                @if(str_starts_with($proyek->status_persetujuan, 'ditolak') && $proyek->catatan_penolakan)
                                                    <button type="button" 
                                                            class="lihat-catatan px-3 py-2 bg-yellow-400 text-yellow-800 text-xs font-semibold rounded-md hover:bg-yellow-500"
                                                            data-catatan="{{ $proyek->catatan_penolakan }}">
                                                        Lihat Catatan
                                                    </button>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-4 text-center text-gray-500">Belum ada data ROW.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Script untuk konfirmasi pengajuan
        document.querySelectorAll('.form-ajukan').forEach(form => {
            form.addEventListener('submit', function (e) {
                e.preventDefault(); 
                let namaProyek = form.getAttribute('data-nama');
                Swal.fire({
                    title: 'Konfirmasi Pengajuan',
                    html: `Apakah Anda yakin ingin mengajukan proyek <strong>${namaProyek}</strong>?`,
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#2563eb',
                    cancelButtonColor: '#6b7280',
                    confirmButtonText: 'Ya, Ajukan',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });

        // Script untuk konfirmasi hapus
        document.querySelectorAll('.form-hapus').forEach(form => {
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

        // Script untuk popup catatan penolakan
        document.querySelectorAll('.lihat-catatan').forEach(button => {
            button.addEventListener('click', function() {
                const catatan = this.getAttribute('data-catatan');
                Swal.fire({
                    title: 'Catatan Penolakan',
                    text: catatan,
                    icon: 'info',
                    confirmButtonColor: '#2563eb',
                    confirmButtonText: 'Mengerti'
                });
            });
        });
    });
    </script>
</x-app-layout>