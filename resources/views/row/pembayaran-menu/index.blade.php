<x-app-layout>
    @push('content-header')
        <x-content-header
            :proyek="$row"
            tahapan="Pembayaran"
        />
    @endpush

    <div class="py-8 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto space-y-6">
        
        {{-- Menggunakan Blade Component untuk notifikasi yang konsisten --}}
        @if (session('success'))
            <x-alert type="success">{{ session('success') }}</x-alert>
        @endif

        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 overflow-x-auto">
                <table class="min-w-full bg-white">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">No</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Span</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Bidang</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Pemilik</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Desa</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Nilai</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Tgl Bayar</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Bukti</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach ($penyampaians as $i => $penyampaian)
                        @php
                            $nilai = $penyampaian->penetapanNilai;
                            $pembayaran = $penyampaian->pembayaranMenu;
                        @endphp
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 text-center">{{ $i + 1 }}</td>
                            <td class="px-6 py-4 text-center">{{ $nilai->span }}</td>
                            <td class="px-6 py-4 text-left">{{ $nilai->no_bidang }}</td>
                            <td class="px-6 py-4 text-left">{{ $nilai->nama_pemilik }}</td>
                            <td class="px-6 py-4 text-left">{{ $nilai->desa }}</td>
                            <td class="px-6 py-4 text-left">
                                Rp {{ number_format($nilai->nilai_kompensasi, 0, ',', '.') }}
                            </td>
                            <td class="px-6 py-4 text-center">
                                @if ($pembayaran?->status === 'TERBAYAR')
                                    <span class="inline-flex items-center px-3 py-1 text-xs font-semibold text-emerald-800 bg-emerald-200 rounded-full">
                                        TERBAYAR
                                    </span>
                                @elseif ($pembayaran?->status === 'BELUM TERBAYAR')
                                    <span class="inline-flex items-center px-3 py-1 text-xs font-semibold text-red-800 bg-red-200 rounded-full">
                                        BELUM
                                    </span>
                                @else
                                    <span class="text-gray-400 text-xs italic">Belum Diisi</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-center">
                                {{ $pembayaran?->tanggal_pembayaran ? \Carbon\Carbon::parse($pembayaran->tanggal_pembayaran)->format('d/m/Y') : '-' }}
                            </td>
                            <td class="px-6 py-4 text-center">
                                @if ($pembayaran && $pembayaran->bukti_dokumen)
                                    <a href="{{ asset('storage/' . $pembayaran->bukti_dokumen) }}" target="_blank"
                                    class="inline-block px-3 py-1 text-xs font-semibold text-blue-800 bg-blue-100 rounded-full hover:underline">
                                        Lihat
                                    </a>
                                @else
                                    <span class="text-gray-400 text-xs">Kosong</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-center">
                                <div class="flex justify-center gap-3">
                                    @if ($pembayaran)
                                        <a href="#" onclick="event.preventDefault(); document.getElementById('form-{{ $pembayaran->id }}').classList.toggle('hidden')" class="text-gray-600 hover:text-indigo-700" title="Edit">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M11 4H6a2 2 0 00-2 2v12a2 2 0 002 2h12a2 2 0 002-2v-5M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z"/>
                                            </svg>
                                        </a>
                                        <form id="delete-form-{{ $pembayaran->id }}" action="{{ route('row.pembayaran-menu.destroy', $pembayaran->id) }}" method="POST" style="display: none;">
                                            @csrf @method('DELETE')
                                        </form>
                                        <button type="button" class="text-gray-600 hover:text-red-700" title="Hapus"
                                            onclick="confirmDelete('{{ route('row.pembayaran-menu.destroy', $pembayaran->id) }}', 'delete-form-{{ $pembayaran->id }}')">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6M9 7h6m2 0a2 2 0 00-2-2H9a2 2 0 00-2 2h10z" />
                                            </svg>
                                        </button>
                                    @else
                                        <a href="#" onclick="event.preventDefault(); document.getElementById('form-create-{{ $penyampaian->id }}').classList.toggle('hidden')" class="text-blue-600 hover:text-blue-900" title="Input Data">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v2H7a1 1 0 100 2h2v2a1 1 0 102 0v-2h2a1 1 0 100-2h-2V7z" clip-rule="evenodd" />
                                            </svg>
                                        </a>
                                    @endif
                                </div>
                            </td>
                        </tr>
                            {{-- FORM UPDATE (TERSEMBUNYI) --}}
                            @if ($pembayaran)
                                <tr id="form-{{ $pembayaran->id }}" class="hidden">
                                    <td colspan="10" class="p-4 bg-gray-50">
                                        <form action="{{ route('row.pembayaran-menu.update', $pembayaran->id) }}" method="POST" enctype="multipart/form-data" class="flex items-end gap-4">
                                            @csrf @method('PUT')
                                            <div>
                                                <label class="block text-xs font-medium text-gray-700">Status</label>
                                                <select name="status" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm text-sm">
                                                    <option value="TERBAYAR" @selected($pembayaran->status == 'TERBAYAR')>TERBAYAR</option>
                                                    <option value="BELUM TERBAYAR" @selected($pembayaran->status == 'BELUM TERBAYAR')>BELUM TERBAYAR</option>
                                                </select>
                                            </div>
                                            <div>
                                                <label class="block text-xs font-medium text-gray-700">Tanggal</label>
                                                <input type="date" name="tanggal_pembayaran" value="{{ $pembayaran->tanggal_pembayaran }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm text-sm">
                                            </div>
                                            <div>
                                                <label class="block text-xs font-medium text-gray-700">Ganti Bukti</label>
                                                <input type="file" name="bukti_dokumen" class="mt-1 block w-full text-xs text-gray-500">
                                            </div>
                                            <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700 text-sm">Simpan</button>
                                        </form>
                                    </td>
                                </tr>
                            @else
                                {{-- FORM CREATE (TERSEMBUNYI) --}}
                                <tr id="form-create-{{ $penyampaian->id }}" class="hidden">
                                     <td colspan="10" class="p-4 bg-gray-50">
                                        <form action="{{ route('row.pembayaran-menu.store', $penyampaian->id) }}" method="POST" enctype="multipart/form-data" class="flex items-end gap-4">
                                            @csrf
                                            <div>
                                                <label class="block text-xs font-medium text-gray-700">Status</label>
                                                <select name="status" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm text-sm">
                                                    <option value="TERBAYAR">TERBAYAR</option>
                                                    <option value="BELUM TERBAYAR">BELUM TERBAYAR</option>
                                                </select>
                                            </div>
                                            <div>
                                                <label class="block text-xs font-medium text-gray-700">Tanggal</label>
                                                <input type="date" name="tanggal_pembayaran" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm text-sm">
                                            </div>
                                            <div>
                                                <label class="block text-xs font-medium text-gray-700">Upload Bukti</label>
                                                <input type="file" name="bukti_dokumen" required class="mt-1 block w-full text-xs text-gray-500">
                                            </div>
                                            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 text-sm">Simpan</button>
                                        </form>
                                    </td>
                                </tr>
                            @endif
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="bg-blue-50 border-l-4 border-blue-400 p-4 text-sm text-blue-800 rounded">
            Hanya data dengan status <strong>SETUJU</strong> dari halaman Penyampaian yang ditampilkan. Silakan isi status <b>Terbayar</b>, <b>Tanggal</b>, dan <b>Upload Bukti Dokumen</b> jika pembayaran telah dilakukan.
        </div>
    </div>
    <script>
        function confirmDelete(deleteUrl) {
                Swal.fire({
                    title: 'Apakah Anda yakin?',
                    text: "Data yang sudah dihapus tidak dapat dikembalikan!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        const deleteForm = document.getElementById('delete-form');
                        
                        deleteForm.action = deleteUrl;
                        
                        deleteForm.submit();
                    }
                });
            }
    </script>
</x-app-layout>
