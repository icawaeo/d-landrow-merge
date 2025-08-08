<x-app-layout>
    @push('content-header')
        <x-content-header
            :proyek="$proyek"
            tahapan="Dokumen Hasil"
        />
    @endpush

    <div class="py-8 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto space-y-6">
        <!-- Form Tambah Data Baru -->
        <div class="bg-white p-4 sm:p-6 rounded-lg shadow">
            <h3 class="text-lg font-semibold mb-4">Tambah Dokumen Hasil</h3>
            <form action="{{ route('dokumenhasil.store') }}" method="POST">
                @csrf

                <input type="hidden" name="pengadaan_tanah_id" value="{{ $proyek->id }}">
                
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                    <input type="text" name="no_surat" placeholder="Nama Surat" class="border border-gray-300 rounded-md px-3 py-2 text-sm w-full" required>
                    <input type="text" name="total_tip_luas" placeholder="Total TIP / Luas" class="border border-gray-300 rounded-md px-3 py-2 text-sm w-full" required>
                    <input type="date" name="tgl_surat" class="border border-gray-300 rounded-md px-3 py-2 text-sm w-full" required>
                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 text-sm w-full">Simpan</button>
                </div>
            </form>
        </div>

        <!-- Tabel Dokumen -->
        <div 
            x-data="{ editingId: null }" 
            class="bg-white p-4 sm:p-6 rounded-lg shadow overflow-x-auto"
        >
            <table class="min-w-full text-sm text-gray-700">
                <thead class="bg-gray-100 text-xs uppercase text-gray-600 tracking-wider">
                    <tr>
                        <th class="px-4 py-3 text-center">No.</th>
                        <th class="px-4 py-3 text-center">Surat</th>
                        <th class="px-4 py-3 text-center">Total TIP/Luas</th>
                        <th class="px-4 py-3 text-center">Tanggal Surat</th>
                        <th class="px-4 py-3 text-center">Dokumen</th>
                        <th class="px-4 py-3 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse ($dokumen as $index => $item)
                        {{-- ============================================= --}}
                        {{-- BARIS UNTUK MODE EDIT (Awalnya tersembunyi) --}}
                        {{-- ============================================= --}}
                        <tr x-show="editingId === {{ $item->id }}" x-cloak>
                            <td class="px-4 py-2 text-center align-top pt-4">{{ $index + 1 }}</td>
                            
                            {{-- Input Surat --}}
                            <td class="px-2 py-2 align-top">
                                <input type="text" name="no_surat" form="edit-form-{{ $item->id }}" value="{{ $item->no_surat }}" class="border-gray-300 rounded-md shadow-sm text-sm w-full">
                            </td>

                            {{-- Input Total TIP/Luas --}}
                            <td class="px-2 py-2 align-top text-center">
                                <input type="text" name="total_tip_luas" form="edit-form-{{ $item->id }}" value="{{ $item->total_tip_luas }}" class="border-gray-300 rounded-md shadow-sm text-sm w-full text-center">
                            </td>
                            
                            {{-- Input Tanggal Surat --}}
                            <td class="px-2 py-2 align-top">
                                <input type="date" name="tgl_surat" form="edit-form-{{ $item->id }}" value="{{ $item->tgl_surat }}" class="border-gray-300 rounded-md shadow-sm text-sm w-full">
                            </td>

                            {{-- Input Dokumen (File) --}}
                            <td class="px-2 py-2 align-middle">
                                <div class="flex flex-col items-center justify-center h-full">
                                    <input type="file" name="file" form="edit-form-{{ $item->id }}" class="text-xs w-full max-w-xs mx-auto">
                                </div>
                            </td>
                            
                            {{-- Tombol Aksi Update & Batal --}}
                            <td class="px-4 py-2 align-top whitespace-nowrap">
                                <form 
                                    id="edit-form-{{ $item->id }}"
                                    action="{{ route('dokumenhasil.update', $item->id) }}" 
                                    method="POST"
                                    enctype="multipart/form-data" {{-- Wajib untuk upload file --}}
                                >
                                    @csrf
                                    @method('PUT')
                                    <div class="flex items-center justify-center space-x-2">
                                        <button type="submit" class="bg-green-600 text-white px-3 py-1.5 rounded-md hover:bg-green-700 text-xs">Update</button>
                                        <button type="button" @click="editingId = null" class="bg-gray-300 text-gray-700 px-3 py-1.5 rounded-md hover:bg-gray-400 text-xs">Batal</button>
                                    </div>
                                </form>
                            </td>
                        </tr>

                        {{-- ============================================= --}}
                        {{-- BARIS UNTUK MODE TAMPIL DATA (VIEW) --}}
                        {{-- ============================================= --}}
                        <tr x-show="editingId !== {{ $item->id }}">
                            <td class="px-4 py-2 text-center">{{ $index + 1 }}</td>
                            <td class="px-4 py-2 ">{{ $item->no_surat }}</td>
                            <td class="px-4 py-2 text-center">{{ $item->total_tip_luas }}</td>
                            <td class="px-4 py-2 text-center">{{ \Carbon\Carbon::parse($item->tgl_surat)->translatedFormat('d F Y') }}</td>
                            <td class="px-4 py-2 text-center">
                                @if ($item->file_path)
                                    <a href="{{ asset('storage/' . $item->file_path) }}" target="_blank" class="inline-block px-3 py-1 text-xs font-semibold text-blue-800 bg-blue-100 rounded-full hover:underline">
                                        Lihat Dokumen
                                    </a>
                                @else
                                    <form action="{{ route('dokumenhasil.upload', $item->id) }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <label for="file-{{ $item->id }}" class="cursor-pointer text-white bg-teal-500 hover:bg-teal-600 font-medium rounded-lg text-xs px-3 py-1.5 text-center">
                                            Upload Doc
                                        </label>
                                        <input type="file" name="file" id="file-{{ $item->id }}" class="hidden" onchange="this.form.submit()">
                                    </form>
                                @endif
                            </td>
                            <td class="px-4 py-2 whitespace-nowrap">
                                <div class="flex items-center justify-center space-x-2">
                                    {{-- Tombol Edit (Icon Pensil) --}}
                                    <button @click="editingId = {{ $item->id }}" class="text-gray-600 hover:text-blue-800 p-1" title="Edit">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 4H6a2 2 0 00-2 2v12a2 2 0 002 2h12a2 2 0 002-2v-5M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                                    </button>
                                    
                                    {{-- Tombol Hapus (Icon Tong Sampah) --}}
                                    <form action="{{ route('dokumenhasil.destroy', $item->id) }}" 
                                        method="POST" 
                                        class="form-hapus"
                                        data-nama="{{ $item->no_surat }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-gray-600 hover:text-red-700" title="Hapus">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6M9 7h6m2 0a2 2 0 00-2-2H9a2 2 0 00-2 2h10z" /></svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-4 py-4 text-center text-gray-500">
                                Belum ada data dokumen.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
    document.querySelectorAll('.form-hapus').forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            let namaSurat = form.getAttribute('data-nama');

            Swal.fire({
                title: 'Hapus Data',
                html: `Apakah Anda yakin ingin menghapus dokumen <strong>${namaSurat}</strong>?<br>`,
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
    </script>

</x-app-layout>
