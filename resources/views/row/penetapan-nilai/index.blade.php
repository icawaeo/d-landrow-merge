<x-app-layout>
    @push('content-header')
        <x-content-header
            :proyek="$row"
            tahapan="Penetapan Nilai"
        />
    @endpush

    <div class="py-8 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto space-y-6">
       @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif

        @if (session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                <span class="block sm:inline">{{ session('error') }}</span>
            </div>
        @endif

        <div class="bg-white p-4 sm:p-6 rounded-lg shadow-sm">
            <div class="flex items-center justify-between">
                <form method="GET" action="{{ route('row.penetapan-nilai.index', $row->id) }}">
                    <div class="flex items-center gap-2">
                        <label for="span_select" class="font-medium text-gray-700">Pilih Span:</label>
                        <select id="span_select" name="span" class="border-gray-300 rounded-md shadow-sm text-sm" onchange="this.form.submit()">
                            <option value="">Semua Span</option>
                            @foreach($spans as $span)
                                <option value="{{ $span }}" @selected($spanFilter == $span)>{{ $span }}</option>
                            @endforeach
                        </select>
                    </div>
                </form>

                <form method="POST" action="{{ route('row.penetapan-nilai.store-span', $row->id) }}">
                    @csrf
                    <div class="flex items-center gap-2">
                        <label for="span_select" class="font-medium text-gray-700">Buat Span:</label>
                        <input type="number" name="start_tip" placeholder="Tip Awal" class="border-gray-300 rounded-md shadow-sm text-sm" required>
                        <span>ke</span>
                        <input type="number" name="end_tip" placeholder="Tip Akhir" class="border-gray-300 rounded-md shadow-sm text-sm" required>
                        <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded-md hover:bg-green-600 text-sm">Tambah</button>
                    </div>
                </form>
            </div>
        </div>

        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 overflow-x-auto">
                <table class="min-w-full bg-white">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">SPAN</th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">NO BIDANG</th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">NAMA PEMILIK</th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">DESA</th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">NILAI KOMPENSASI</th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">AKSI</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach ($penetapanNilais as $item)
                            @if (isset($itemToEdit) && $itemToEdit->id === $item->id)
                                <form method="POST" action="{{ route('row.penetapan-nilai.update', [$row->id, $item->id]) }}">
                                    @csrf
                                    @method('PUT')
                                    <tr class="bg-yellow-50">
                                        <td class="px-6 py-4 whitespace-nowrap"><input type="text" value="{{ $item->span }}" class="w-full bg-gray-100 border-gray-300 rounded-md shadow-sm text-sm" readonly></td>
                                        <td class="px-6 py-4 whitespace-nowrap"><input type="text" name="no_bidang" value="{{ $item->no_bidang }}" class="w-full border-gray-300 rounded-md shadow-sm text-sm"></td>
                                        <td class="px-6 py-4 whitespace-nowrap"><input type="text" name="nama_pemilik" value="{{ $item->nama_pemilik }}" class="w-full border-gray-300 rounded-md shadow-sm text-sm"></td>
                                        <td class="px-6 py-4 whitespace-nowrap"><input type="text" name="desa" value="{{ $item->desa }}" class="w-full border-gray-300 rounded-md shadow-sm text-sm"></td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <input type="text" name="nilai_kompensasi" value="{{ $item->nilai_kompensasi }}" class="w-full border-gray-300 rounded-md shadow-sm text-sm">
                                            @error('nilai_kompensasi') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center space-x-2">
                                                <button type="submit" class="text-white bg-green-600 hover:bg-green-700 font-medium rounded-lg text-sm px-3 py-1.5">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                                    </svg>
                                                </button>
                                                <a href="{{ route('row.penetapan-nilai.index', [$row->id, 'span' => $span]) }}" class="text-gray-600 hover:text-gray-900">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                    </svg>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                </form>
                            @else
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-center">{{ $item->span }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $item->no_bidang }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $item->nama_pemilik }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $item->desa }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">Rp. {{ number_format($item->nilai_kompensasi, 0, ',', '.') }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-center">
                                        <div class="flex justify-center items-center space-x-3">
                                            <!-- Tombol Edit -->
                                            <a href="{{ route('row.penetapan-nilai.edit', [$row->id, $item->id]) }}" class="text-gray-500 hover:text-blue-600" title="Edit">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5M18.5 2.5a2.121 2.121 0 113 3L12 15l-4 1 1-4 9.5-9.5z"/>
                                                </svg>
                                            </a>

                                            <!-- Tombol Hapus -->
                                            <button type="button" onclick="confirmDelete(`{{ route('row.penetapan-nilai.destroy', [$row->id, $item->id]) }}`)" class="text-gray-500 hover:text-red-600" title="Hapus">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6M1 7h22M10 3h4a1 1 0 011 1v1H9V4a1 1 0 011-1z"/>
                                                </svg>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @endif
                        @endforeach

                        @if(!empty($spanFilter))
                            <form method="POST" action="{{ route('row.penetapan-nilai.store', $row->id) }}">
                                @csrf
                                <input type="hidden" name="span" value="{{ $spanFilter }}">
                                <tr class="bg-gray-50">
                                    <td class="px-6 py-4"><input type="text" value="{{ $spanFilter }}" class="w-full bg-gray-100 border-gray-300 rounded-md shadow-sm text-sm" readonly></td>
                                    <td class="px-6 py-4"><input type="text" name="no_bidang" class="w-full border-gray-300 rounded-md shadow-sm text-sm" required></td>
                                    <td class="px-6 py-4"><input type="text" name="nama_pemilik" class="w-full border-gray-300 rounded-md shadow-sm text-sm" required></td>
                                    <td class="px-6 py-4"><input type="text" name="desa" class="w-full border-gray-300 rounded-md shadow-sm text-sm" required></td>
                                    <td class="px-6 py-4">
                                        <input type="text" name="nilai_kompensasi" class="w-full border-gray-300 rounded-md shadow-sm text-sm" required>
                                        @error('nilai_kompensasi') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                    </td>
                                    <td class="px-6 py-4 text-left">
                                        <button type="submit" class="bg-blue-600 text-white text-sm px-4 py-2 rounded-md hover:bg-blue-700">Simpan</button>
                                    </td>
                                </tr>
                            </form>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div id="deleteModal" class="fixed inset-0 z-50 items-center justify-center bg-black bg-opacity-50 hidden">...</div>

    <form id="delete-form" action="" method="POST" style="display: none;">
        @csrf
        @method('DELETE')
    </form>

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
