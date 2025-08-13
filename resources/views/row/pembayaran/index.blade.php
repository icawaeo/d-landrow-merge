<x-app-layout>
    @php
        $isReadOnly = !($row->status_persetujuan === 'belum_diajukan' || str_starts_with($row->status_persetujuan, 'ditolak'));
    @endphp

    @push('content-header')
        <x-content-header
            :proyek="$row"
            tahapan="Pembayaran"
            :tambahDataUrl="$isReadOnly ? null : route('row.pembayaran.create', $row->id)"
        />
    @endpush

    <div class="py-2">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="overflow-x-auto">
                        <table class="min-w-full bg-white">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">No.</th>
                                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Kecamatan</th>
                                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal Pelaksanaan</th>
                                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Lampiran</th>
                                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @forelse($pembayarans as $item)
                                <tr>
                                    <td class="px-6 py-4 text-center">{{ $loop->iteration }}</td>
                                    <td class="px-6 py-4 text-center">{{ $item->nama_kecamatan }}</td>
                                    <td class="px-6 py-4 text-center">{{ $item->status }}</td>
                                    <td class="px-6 py-4 text-center">{{ \Carbon\Carbon::parse($item->tanggal_pelaksanaan)->format('d/m/Y') }}</td>
                                    <td class="px-6 py-4 text-center">
                                        @if($item->lampiran_berita_acara)
                                        <a href="{{ Storage::url($item->lampiran_berita_acara) }}" target="_blank" class="text-blue-600 hover:underline">Lihat Dokumen</a>
                                        @else
                                        <span class="text-gray-400">Kosong</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-center">
                                        @if(!$isReadOnly)
                                            <div class="flex justify-center items-center gap-2">
                                                <a href="{{ route('row.pembayaran.edit', $item->id) }}" class="text-gray-600 hover:text-blue-800 p-1" title="Ubah">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 4H6a2 2 0 00-2 2v12a2 2 0 002 2h12a2 2 0 002-2v-5M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                                                </a>
                                                <form class="form-hapus" action="{{ route('row.pembayaran.destroy', $item->id) }}" method="POST" data-nama="{{ $item->nama_kecamatan }}">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-gray-600 hover:text-red-700 p-1" title="Hapus">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6M9 7h6m2 0a2 2 0 00-2-2H9a2 2 0 00-2 2h10z" /></svg>
                                                    </button>
                                                </form>
                                            </div>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center py-4 text-gray-500">Belum ada data. Silakan klik tombol "+ Tambah Data".</td>
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
            document.querySelectorAll('.form-hapus').forEach(form => {
                form.addEventListener('submit', function(e) {
                    e.preventDefault();
                    let nama = form.getAttribute('data-nama');

                    Swal.fire({
                        title: 'Hapus Data',
                        html: `Apakah Anda yakin ingin menghapus data untuk <strong>${nama}</strong>?`,
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
    
</x-app-layout>
