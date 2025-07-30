<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4">
            <a href="{{ url()->previous() }}" class="text-gray-500 hover:text-gray-700">
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
            </a>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Penetapan Nilai</h2>
        </div>
    </x-slot>

    <div class="py-8 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto space-y-6">
        
        {{-- PERBAIKAN: Menggunakan Blade Component untuk Notifikasi --}}
        @if (session('success'))
            <x-alert type="success">{{ session('success') }}</x-alert>
        @endif

        @if ($errors->any())
            <x-alert type="danger">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </x-alert>
        @endif

        <div class="bg-white p-4 sm:p-6 rounded-lg shadow-sm">
            <form method="GET" action="{{ route('row.penetapan-nilai.index', $row->id) }}">
                <div class="flex items-center gap-2">
                    <label for="span_select" class="font-medium text-gray-700">Pilih Span:</label>
                    <select id="span_select" name="span"
                            class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm text-sm"
                            onchange="this.form.submit()">
                        <option value="1 ke 2" {{ $span == '1 ke 2' ? 'selected' : '' }}>TIP 1 ke TIP 2</option>
                        <option value="2 ke 3" {{ $span == '2 ke 3' ? 'selected' : '' }}>TIP 2 ke TIP 3</option>
                    </select>
                </div>
            </form>
        </div>

        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 overflow-x-auto">
                {{-- PERBAIKAN: Mengubah gaya tabel agar konsisten --}}
                <table class="min-w-full bg-white">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">SPAN</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">NO BIDANG</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">NAMA PEMILIK</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">DESA</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">NILAI KOMPENSASI</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">AKSI</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach ($data as $item)
                            @if (isset($itemToEdit) && $itemToEdit->id === $item->id)
                                {{-- Mode Edit --}}
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
                                                <button type="submit" class="text-white bg-green-600 hover:bg-green-700 font-medium rounded-lg text-sm px-3 py-1.5">Update</button>
                                                <a href="{{ route('row.penetapan-nilai.index', [$row->id, 'span' => $span]) }}" class="text-gray-600 hover:text-gray-900">Batal</a>
                                            </div>
                                        </td>
                                    </tr>
                                </form>
                            @else
                                {{-- Mode Tampilan Normal --}}
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $item->span }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $item->no_bidang }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $item->nama_pemilik }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $item->desa }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">Rp. {{ number_format($item->nilai_kompensasi, 0, ',', '.') }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <div class="flex items-center space-x-4">
                                            <a href="{{ route('row.penetapan-nilai.edit', [$row->id, $item->id]) }}" class="text-indigo-600 hover:text-indigo-900">Edit</a>
                                            <button type="button" onclick="confirmDelete(`{{ route('row.penetapan-nilai.destroy', [$row->id, $item->id]) }}`)" class="text-red-600 hover:text-red-900">Hapus</button>
                                        </div>
                                    </td>
                                </tr>
                            @endif
                        @endforeach

                        {{-- Form Tambah --}}
                        <form method="POST" action="{{ route('row.penetapan-nilai.store', $row->id) }}">
                            @csrf
                            <input type="hidden" name="span" value="{{ $span }}">
                            <tr class="bg-gray-50">
                                <td class="px-6 py-4"><input type="text" value="{{ $span }}" class="w-full bg-gray-100 border-gray-300 rounded-md shadow-sm text-sm" readonly></td>
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
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div id="deleteModal" class="fixed inset-0 z-50 items-center justify-center bg-black bg-opacity-50 hidden">...</div>
    <script>
    </script>
</x-app-layout>