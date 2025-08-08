<x-app-layout>
    @push('content-header')
        <x-content-header
            :proyek="$proyek"
            tahapan="Musyawarah"
            :tambahDataUrl="route('musyawarah_sub.create', $proyek->id)"
        />
    @endpush

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="overflow-x-auto">
                        <table class="min-w-full bg-white">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No.</th>
                                    {{-- PERUBAHAN LABEL KOLOM --}}
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Kecamatan</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Lampiran</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @forelse($musyawarahs as $item)
                                <tr>
                                    <td class="px-6 py-4">{{ $loop->iteration }}</td>
                                    {{-- Tetap memanggil 'nama_kecamatan' karena itu nama kolom di DB --}}
                                    <td class="px-6 py-4">{{ $item->nama_kecamatan }}</td>
                                    <td class="px-6 py-4">{{ $item->status }}</td>
                                    <td class="px-6 py-4">{{ \Carbon\Carbon::parse($item->tanggal_pelaksanaan)->format('d/m/Y') }}</td>
                                    <td class="px-6 py-4">
                                        {{-- Memastikan nama kolom lampiran benar --}}
                                        @if($item->lampiran_berita_acara)
                                        <a href="{{ Storage::url($item->lampiran_berita_acara) }}" target="_blank" class="text-blue-600 hover:underline">Lihat Dokumen</a>
                                        @else
                                        <span class="text-gray-400">Kosong</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <div class="flex items-center gap-4">
                                            <a href="{{ route('musyawarah_sub.edit', $item->id) }}" class="text-indigo-600 hover:text-indigo-900">Ubah</a>
                                            <form action="{{ route('musyawarah_sub.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus data ini?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900">Hapus</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr><td colspan="6" class="text-center py-4 text-gray-500">Belum ada data.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>