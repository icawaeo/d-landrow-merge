<x-app-layout>
    @php
        $isReadOnly = !($proyek->status_persetujuan === 'belum_diajukan' || str_starts_with($proyek->status_persetujuan, 'ditolak'));
    @endphp

    @push('content-header')
        <x-content-header
            :proyek="$proyek"
            tahapan="Musyawarah"
        />
    @endpush

    <div class="py-2">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <div class="overflow-x-auto">
                    <table class="min-w-full bg-white">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No.</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No Tip</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Pemilik</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Desa</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nilai</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Bukti Dokumen</th>
                                <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @foreach($musyawarahItems as $item)
                                @if(isset($itemToEdit) && $itemToEdit->id === $item->id)
                                    {{-- MODE EDIT --}}
                                    <form action="{{ route('musyawarah.update', $itemToEdit->id) }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        @method('PUT')
                                        <tr class="bg-yellow-50">
                                            <td class="px-4 py-2 whitespace-nowrap">{{ $loop->iteration }}</td>
                                            <td class="px-1 py-1"><input type="text" name="no_tip" value="{{ old('no_tip', $itemToEdit->no_tip) }}" class="w-full border-gray-300 rounded-md shadow-sm text-sm"></td>
                                            <td class="px-1 py-1"><input type="text" name="nama_pemilik" value="{{ old('nama_pemilik', $itemToEdit->nama_pemilik) }}" class="w-full border-gray-300 rounded-md shadow-sm text-sm"></td>
                                            <td class="px-1 py-1"><input type="text" name="desa" value="{{ old('desa', $itemToEdit->desa) }}" class="w-full border-gray-300 rounded-md shadow-sm text-sm"></td>
                                            <td class="px-1 py-1"><input type="number" step="any" name="nilai" value="{{ old('nilai', $itemToEdit->nilai) }}" class="w-full border-gray-300 rounded-md shadow-sm text-sm"></td>
                                            <td class="px-1 py-1">
                                                {{-- PERUBAHAN: Menambahkan opsi status --}}
                                                <select name="status" class="w-full border-gray-300 rounded-md shadow-sm text-sm">
                                                    <option value="SETUJU" @selected(old('status', $itemToEdit->status) == 'SETUJU')>SETUJU</option>
                                                    <option value="TIDAK SETUJU" @selected(old('status', $itemToEdit->status) == 'TIDAK SETUJU')>TIDAK SETUJU</option>
                                                    <option value="MENOLAK" @selected(old('status', $itemToEdit->status) == 'MENOLAK')>MENOLAK</option>
                                                </select>
                                            </td>
                                            <td class="px-2 py-1 whitespace-nowrap">
                                                <input type="file" name="bukti_dokumen" class="text-xs w-full">
                                                @if ($itemToEdit->bukti_musyawarah)
                                                    <a href="{{ Storage::url($itemToEdit->bukti_musyawarah) }}" target="_blank" class="text-blue-600 text-xs hover:underline block mt-1">
                                                        Lihat File Saat Ini
                                                    </a>
                                                @endif
                                            </td>
                                            <td class="px-4 py-2 text-center">
                                                <div class="flex justify-center items-center space-x-2">
                                                    <button type="submit" class="text-white bg-green-600 hover:bg-green-700 font-medium rounded-lg text-sm px-3 py-1.5">Update</button>
                                                    <a href="{{ route('musyawarah.index', $proyek->id) }}" class="text-gray-600 hover:text-gray-900">Batal</a>
                                                </div>
                                            </td>
                                        </tr>
                                    </form>
                                @else
                                    {{-- MODE NORMAL --}}
                                    <tr>
                                        <td class="px-4 py-2 whitespace-nowrap">{{ $loop->iteration }}</td>
                                        <td class="px-4 py-2 whitespace-nowrap">{{ $item->no_tip }}</td>
                                        <td class="px-4 py-2 whitespace-nowrap">{{ $item->nama_pemilik }}</td>
                                        <td class="px-4 py-2 whitespace-nowrap">{{ $item->desa }}</td>
                                        <td class="px-4 py-2 whitespace-nowrap">Rp. {{ number_format($item->nilai, 0, ',', '.') }}</td>
                                        <td class="px-4 py-2 whitespace-nowrap">{{ $item->status }}</td>
                                        <td class="px-4 py-2 whitespace-nowrap">

                                                <form action="{{ route('musyawarah.upload', $item->id) }}" method="POST" enctype="multipart/form-data">
                                                    @csrf
                                                    @if ($item->bukti_musyawarah)
                                                        <a href="{{ Storage::url($item->bukti_musyawarah) }}" target="_blank" class="text-blue-600 hover:underline">Lihat</a>
                                                    @else
                                                        <label for="file-{{$item->id}}" class="cursor-pointer text-white bg-teal-500 hover:bg-teal-600 font-medium rounded-lg text-sm px-3 py-1.5 text-center">Upload</label>
                                                        <input type="file" name="bukti_dokumen" id="file-{{$item->id}}" class="hidden" onchange="this.form.submit()">
                                                    @endif
                                                </form>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">

                                        @if(!$isReadOnly)
                                            <div class="flex items-center gap-2">
                                                <a href="{{ route('musyawarah.edit', $item->id) }}" class="text-gray-600 hover:text-blue-800 p-1" title="Ubah">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 4H6a2 2 0 00-2 2v12a2 2 0 002 2h12a2 2 0 002-2v-5M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                                                </a>
                                                <form class="form-hapus" action="{{ route('musyawarah.destroy', $item->id) }}" method="POST" data-nama="{{ $item->nama_kecamatan }}">
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
                                @endif
                            @endforeach

                            {{-- Form untuk menambah data baru --}}
                            @if(!$isReadOnly)
                                <form action="{{ route('musyawarah.store', $proyek->id) }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <tr class="bg-gray-50">
                                        <td class="px-4 py-2"></td>
                                        <td class="px-1 py-1"><input type="text" name="no_tip" placeholder="Add Data" class="w-full border-gray-300 rounded-md shadow-sm text-sm" required></td>
                                        <td class="px-1 py-1"><input type="text" name="nama_pemilik" placeholder="Add Data" class="w-full border-gray-300 rounded-md shadow-sm text-sm" required></td>
                                        <td class="px-1 py-1"><input type="text" name="desa" placeholder="Add Data" class="w-full border-gray-300 rounded-md shadow-sm text-sm" required></td>
                                        <td class="px-1 py-1"><input type="number" step="any" name="nilai" placeholder="Add Data" class="w-full border-gray-300 rounded-md shadow-sm text-sm" required></td>
                                        <td class="px-1 py-1">
                                            {{-- PERUBAHAN: Menambahkan opsi status --}}
                                            <select name="status" class="w-full border-gray-300 rounded-md shadow-sm text-sm" required>
                                                <option value="SETUJU">SETUJU</option>
                                                <option value="TIDAK SETUJU">TIDAK SETUJU</option>
                                                <option value="MENOLAK">MENOLAK</option>
                                            </select>
                                        </td>
                                        <td class="px-1 py-1">
                                            <input type="file" name="bukti_dokumen" class="w-full text-xs">
                                        </td>
                                        <td class="px-4 py-2 text-center">
                                            <button type="submit" class="text-white bg-blue-600 hover:bg-blue-700 font-medium rounded-lg text-sm px-4 py-2">Simpan</button>
                                        </td>
                                    </tr>
                                </form>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.querySelectorAll('.form-hapus').forEach(form => {
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                let nama = form.getAttribute('data-nama');

                Swal.fire({
                    title: 'Hapus Data',
                    html: `Apakah Anda yakin ingin menghapus data musyawarah untuk <strong>${nama}</strong>?`,
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
