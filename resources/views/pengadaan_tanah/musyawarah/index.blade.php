<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4">
            <a href="{{ url()->previous() }}" class="text-gray-500 hover:text-gray-700">
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
            </a>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Musyawarah/Penyampaian Nilai: {{ $proyek->nama_proyek }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
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
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
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
                                            <td class="px-4 py-2 whitespace-nowrap">
                                                <div class="flex items-center space-x-2">
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
                                        <td class="px-4 py-2 whitespace-nowrap">
                                            <div class="flex items-center space-x-4">
                                                <a href="{{ route('musyawarah.edit', $item->id) }}" class="text-indigo-600 hover:text-indigo-900">Edit</a>
                                                <form action="{{ route('musyawarah.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Anda yakin ingin menghapus data ini?');" class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-600 hover:text-red-900">Hapus</button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endif
                            @endforeach

                            {{-- Form untuk menambah data baru --}}
                            <form action="{{ route('musyawarah.store', $proyek->id) }}" method="POST">
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
                                    <td class="px-4 py-2"></td>
                                    <td class="px-4 py-2">
                                        <button type="submit" class="text-white bg-blue-600 hover:bg-blue-700 font-medium rounded-lg text-sm px-4 py-2">Simpan</button>
                                    </td>
                                </tr>
                            </form>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
