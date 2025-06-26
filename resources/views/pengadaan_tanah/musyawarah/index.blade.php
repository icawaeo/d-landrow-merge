<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4">
            <a href="{{ route('homepage') }}" class="text-gray-500 hover:text-gray-700">
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
            </a>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">MUSYAWARAH/PENYAMPAIAN NILAI: {{ $proyek->nama_proyek }}</h2>
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
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            {{-- Menampilkan data yang sudah ada --}}
                            @foreach($musyawarahItems as $item)
                                <tr>
                                    <td class="px-4 py-2">{{ $loop->iteration }}</td>
                                    <td class="px-4 py-2">{{ $item->no_tip }}</td>
                                    <td class="px-4 py-2">{{ $item->nama_pemilik }}</td>
                                    <td class="px-4 py-2">{{ $item->desa }}</td>
                                    <td class="px-4 py-2">Rp. {{ number_format($item->nilai, 0, ',', '.') }}</td>
                                    <td class="px-4 py-2">{{ $item->status }}</td>
                                    <td class="px-4 py-2">
                                        <form action="{{ route('musyawarah.upload', $item->id) }}" method="POST" enctype="multipart/form-data">
                                            @csrf
                                            @if ($item->bukti_dokumen)
                                                <a href="{{ Storage::url($item->bukti_dokumen) }}" target="_blank" class="text-blue-600 hover:underline">Lihat Dokumen</a>
                                            @else
                                                <label for="file-{{$item->id}}" class="cursor-pointer text-white bg-teal-500 hover:bg-teal-600 focus:ring-4 focus:outline-none focus:ring-teal-300 font-medium rounded-lg text-sm px-4 py-2 text-center">Upload Doc</label>
                                                <input type="file" name="bukti_dokumen" id="file-{{$item->id}}" class="hidden" onchange="this.form.submit()">
                                            @endif
                                        </form>
                                    </td>
                                </tr>
                            @endforeach

                            {{-- Form untuk menambah data baru (inline) --}}
                            <form action="{{ route('musyawarah.store', $proyek->id) }}" method="POST">
                                @csrf
                                <tr class="bg-gray-50">
                                    <td class="px-4 py-2 font-bold">Baru:</td>
                                    <td class="px-1 py-1"><input type="text" name="no_tip" placeholder="Add Data" class="w-full border-gray-300 rounded-md shadow-sm text-sm"></td>
                                    <td class="px-1 py-1"><input type="text" name="nama_pemilik" placeholder="Add Data" class="w-full border-gray-300 rounded-md shadow-sm text-sm"></td>
                                    <td class="px-1 py-1"><input type="text" name="desa" placeholder="Add Data" class="w-full border-gray-300 rounded-md shadow-sm text-sm"></td>
                                    <td class="px-1 py-1"><input type="number" name="nilai" placeholder="Add Data" class="w-full border-gray-300 rounded-md shadow-sm text-sm"></td>
                                    <td class="px-1 py-1">
                                        <select name="status" class="w-full border-gray-300 rounded-md shadow-sm text-sm">
                                            <option value="SETUJU">SETUJU</option>
                                            <option value="MENOLAK">MENOLAK</option>
                                        </select>
                                    </td>
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