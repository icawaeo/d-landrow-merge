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
        @if (session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-800 p-4 rounded text-sm">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="bg-red-100 border-l-4 border-red-500 text-red-800 p-4 rounded text-sm">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Dropdown Filter Span -->
        <div class="bg-white p-4 sm:p-6 rounded shadow">
            <form method="GET" action="{{ route('row.penetapan-nilai.index', $row->id) }}">
                <div class="flex items-center gap-2">
                    <label for="span_select" class="font-medium text-gray-700">Pilih Span:</label>
                    <select id="span_select" name="span"
                        class="border rounded px-3 py-2 text-sm pr-8 min-w-[160px]"
                        onchange="this.form.submit()">
                        <option value="1 ke 2" {{ $span == '1 ke 2' ? 'selected' : '' }}>TIP 1 ke TIP 2</option>
                        <option value="2 ke 3" {{ $span == '2 ke 3' ? 'selected' : '' }}>TIP 2 ke TIP 3</option>
                        <!-- Tambahkan opsi lain jika perlu -->
                    </select>
                </div>
            </form>
        </div>

        <!-- Tabel Data -->
        <div class="bg-white p-4 sm:p-6 rounded shadow overflow-x-auto">
            <form method="POST" action="{{ route('row.penetapan-nilai.store', $row->id) }}">
                @csrf
                <input type="hidden" name="span" value="{{ $span }}">
                <table class="min-w-full text-sm text-gray-700 border border-gray-200">
                    <thead class="bg-gray-50">
                        <tr class="text-left">
                            <th class="border px-4 py-2">SPAN</th>
                            <th class="border px-4 py-2">NO BIDANG</th>
                            <th class="border px-4 py-2">NAMA PEMILIK</th>
                            <th class="border px-4 py-2">DESA</th>
                            <th class="border px-4 py-2">NILAI KOMPENSASI</th>
                            <th class="border px-4 py-2 text-center">AKSI</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $item)
                            <tr>
                                @if (isset($itemToEdit) && $itemToEdit->id === $item->id)
                                    <form method="POST" action="{{ route('row.penetapan-nilai.update', [$row->id, $item->id]) }}">
                                        @csrf
                                        @method('PUT')
                                        <td class="border px-4 py-2"><input type="text" name="span" value="{{ $item->span }}" class="w-full border rounded px-2 py-1" readonly></td>
                                        <td class="border px-4 py-2"><input type="text" name="no_bidang" value="{{ $item->no_bidang }}" class="w-full border rounded px-2 py-1"></td>
                                        <td class="border px-4 py-2"><input type="text" name="nama_pemilik" value="{{ $item->nama_pemilik }}" class="w-full border rounded px-2 py-1"></td>
                                        <td class="border px-4 py-2"><input type="text" name="desa" value="{{ $item->desa }}" class="w-full border rounded px-2 py-1"></td>
                                        <td class="border px-4 py-2"><input type="text" name="nilai_kompensasi" value="{{ $item->nilai_kompensasi }}" class="w-full border rounded px-2 py-1"></td>
                                        <td class="border px-4 py-2 text-center">
                                            <button type="submit" class="bg-green-600 text-white px-3 py-1 rounded hover:bg-green-700 text-sm">Update</button>
                                            <a href="{{ route('row.penetapan-nilai.index', [$row->id, 'span' => $span]) }}" class="text-gray-500 text-sm">Batal</a>
                                        </td>
                                    </form>
                                @else
                                    <td class="border px-4 py-2">{{ $item->span }}</td>
                                    <td class="border px-4 py-2">{{ $item->no_bidang }}</td>
                                    <td class="border px-4 py-2">{{ $item->nama_pemilik }}</td>
                                    <td class="border px-4 py-2">{{ $item->desa }}</td>
                                    <td class="border px-4 py-2">Rp. {{ number_format($item->nilai_kompensasi, 0, ',', '.') }}</td>
                                    <td class="border px-4 py-2 text-center space-x-2">
                                        <a href="{{ route('row.penetapan-nilai.edit', [$row->id, $item->id]) }}" class="text-blue-600 text-sm hover:underline">Edit</a>
                                        <button type="button" onclick="confirmDelete(`{{ route('row.penetapan-nilai.destroy', [$row->id, $item->id]) }}`)" class="text-red-600 text-sm hover:underline">Hapus</button>
                                    </td>
                                @endif
                            </tr>
                        @endforeach

                        <!-- Form Tambah -->
                        <tr>
                            <td class="border px-4 py-2"><input type="text" name="span" value="{{ $span }}" class="w-full border rounded px-2 py-1" readonly></td>
                            <td class="border px-4 py-2"><input type="text" name="no_bidang" class="w-full border rounded px-2 py-1" required></td>
                            <td class="border px-4 py-2"><input type="text" name="nama_pemilik" class="w-full border rounded px-2 py-1" required></td>
                            <td class="border px-4 py-2"><input type="text" name="desa" class="w-full border rounded px-2 py-1" required></td>
                            <td class="border px-4 py-2"><input type="text" name="nilai_kompensasi" class="w-full border rounded px-2 py-1" required></td>
                            <td class="border px-4 py-2 text-center"><button type="submit" class="bg-blue-600 text-white text-sm px-4 py-2 rounded hover:bg-blue-700">Simpan</button></td>
                        </tr>
                    </tbody>
                </table>
            </form>
        </div>

        <!-- Info -->
        <div class="bg-yellow-100 border-l-4 border-yellow-400 text-yellow-800 p-4 rounded text-sm">
            <p>Data ditampilkan berdasarkan pilihan span. Gunakan dropdown untuk mengganti.</p>
        </div>
    </div>

    <!-- Modal Konfirmasi Hapus -->
    <div id="deleteModal" class="fixed inset-0 z-50 items-center justify-center bg-black bg-opacity-50 hidden">
        <div class="bg-white rounded-lg shadow-lg max-w-sm w-full p-6">
            <h2 class="text-lg font-semibold text-gray-800 mb-4">Konfirmasi Hapus</h2>
            <p class="text-sm text-gray-600 mb-6">Apakah Anda yakin ingin menghapus data ini? Tindakan ini tidak dapat dibatalkan.</p>

            <form method="POST" id="deleteForm" class="flex justify-end gap-2">
                @csrf
                @method('DELETE')
                <button type="button" onclick="closeModal()" class="px-4 py-2 bg-gray-300 text-gray-800 rounded hover:bg-gray-400 text-sm">Batal</button>
                <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700 text-sm">Hapus</button>
            </form>
        </div>
    </div>

    <!-- Script Modal -->
    <script>
        function confirmDelete(url) {
            const modal = document.getElementById('deleteModal');
            document.getElementById('deleteForm').action = url;
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }

        function closeModal() {
            const modal = document.getElementById('deleteModal');
            modal.classList.remove('flex');
            modal.classList.add('hidden');
        }
    </script>
</x-app-layout>
