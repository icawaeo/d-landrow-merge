<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('SISTEM DIGITAL ROW & PENGADAAN LAHAN') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            {{-- Salam Sambutan Personal --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 border-b border-gray-200">
                    Selamat datang kembali, <strong>{{ Auth::user()->name }}</strong>!
                </div>
            </div>

            {{-- Kartu Statistik (Cards) --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                {{-- Anda bisa meletakkan kode kartu statistik di sini jika ada --}}
            </div>

            {{-- TABEL PENGADAAN TANAH --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-xl font-semibold text-gray-800 mb-4">Tabel Pengadaan Tanah</h3>
                    <div class="overflow-x-auto">
                        <table class="min-w-full bg-white">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Proyek</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jumlah Tower</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Provinsi</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kabupaten</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kecamatan</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Desa</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @forelse($daftarPengadaanTanah as $proyek)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $proyek->nama_proyek }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $proyek->jumlah_tower }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $proyek->provinsi }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $proyek->kabupaten }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $proyek->kecamatan }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $proyek->desa }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <div class="flex items-center gap-4">
                                            @if($proyek->status_persetujuan === 'belum_diajukan' || str_starts_with($proyek->status_persetujuan, 'ditolak'))
                                                <a href="{{ route('pengadaan_tanah.edit', $proyek->id) }}" class="text-indigo-600 hover:text-indigo-900">Edit</a>
                                                <form action="{{ route('pengadaan_tanah.destroy', $proyek->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-600 hover:text-red-900">Hapus</button>
                                                </form>
                                                <form action="{{ route('pengadaan_tanah.submit', $proyek->id) }}" method="POST">
                                                    @csrf
                                                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white text-xs font-semibold rounded-md hover:bg-blue-700">Ajukan</button>
                                                </form>
                                                @if(str_starts_with($proyek->status_persetujuan, 'ditolak'))
                                                    <span class="text-xs text-red-500">(Ditolak)</span>
                                                @endif
                                            @elseif($proyek->status_persetujuan === 'disetujui')
                                                <div class="flex items-center gap-2">
                                                    <span class="h-3 w-3 bg-green-500 rounded-full"></span>
                                                    <span class="text-green-600 font-semibold">Disetujui</span>
                                                </div>
                                            @else
                                                <span class="text-xs text-yellow-600 font-semibold">{{ ucwords(str_replace('_', ' ', $proyek->status_persetujuan)) }}</span>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="px-6 py-4 text-center text-gray-500">
                                        Belum ada data Pengadaan Tanah.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            {{-- TABEL ROW --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-xl font-semibold text-gray-800 mb-4">Tabel ROW</h3>
                    <div class="overflow-x-auto">
                        <table class="min-w-full bg-white">
                             <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Proyek</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jumlah Tower</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Provinsi</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kabupaten</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kecamatan</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Desa</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @forelse($daftarRow as $proyek)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $proyek->nama_proyek }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $proyek->jumlah_tower }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $proyek->provinsi }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $proyek->kabupaten }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $proyek->kecamatan }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $proyek->desa }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <div class="flex items-center gap-4">
                                                @if($proyek->status_persetujuan === 'belum_diajukan' || str_starts_with($proyek->status_persetujuan, 'ditolak'))
                                                    <a href="{{ route('row.edit', $proyek->id) }}" class="text-indigo-600 hover:text-indigo-900">Edit</a>
                                                    <form action="{{ route('row.destroy', $proyek->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="text-red-600 hover:text-red-900">Hapus</button>
                                                    </form>
                                                    <form action="{{ route('row.submit', $proyek->id) }}" method="POST">
                                                        @csrf
                                                        <button type="submit" class="px-4 py-2 bg-blue-600 text-white text-xs font-semibold rounded-md hover:bg-blue-700">Ajukan</button>
                                                    </form>
                                                    @if(str_starts_with($proyek->status_persetujuan, 'ditolak'))
                                                        <div class="group relative">
                                                            <span class="text-xs text-red-500 font-semibold cursor-pointer">(Ditolak)</span>
                                                            {{-- KUNCI UTAMA: Tooltip/Box untuk catatan --}}
                                                            @if($proyek->catatan_penolakan)
                                                                <div class="absolute hidden group-hover:block bg-white border border-gray-300 shadow-lg p-3 rounded-md z-10 w-64 -mt-24">
                                                                    <p class="text-xs font-bold text-gray-800 mb-1">Catatan Penolakan:</p>
                                                                    <p class="text-xs text-gray-600">{{ $proyek->catatan_penolakan }}</p>
                                                                </div>
                                                            @endif
                                                        </div>
                                                    @endif
                                                @elseif($proyek->status_persetujuan === 'disetujui')
                                                    <div class="flex items-center gap-2">
                                                        <span class="h-3 w-3 bg-green-500 rounded-full"></span>
                                                        <span class="text-green-600 font-semibold">Disetujui</span>
                                                    </div>
                                                @else
                                                    <span class="text-xs text-yellow-600 font-semibold">{{ ucwords(str_replace('_', ' ', $proyek->status_persetujuan)) }}</span>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="7" class="px-6 py-4 text-center text-gray-500">
                                            Belum ada data ROW.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>