<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Penyampaian: {{ $row->nama_proyek }}</h2>
    </x-slot>

    <div class="py-8 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto space-y-6">
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

        <!-- Filter Span -->
        <div class="bg-white p-4 sm:p-6 rounded-lg shadow-sm">
            <form method="GET" action="{{ route('row.penyampaian.index', $row->id) }}">
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
        </div>

        <!-- Tabel Data -->
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 overflow-x-auto">
                <table class="min-w-full bg-white">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">No Bidang</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nama Pemilik</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nilai Kompensasi</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status Persetujuan</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Dokumen</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse ($penetapanNilais as $item)
                            @if($item->penyampaian)
                                {{-- JIKA SUDAH ADA DATA PENYAMPAIAN, TAMPILKAN FORM UPDATE --}}
                                <form action="{{ route('row.penyampaian.update', $item->penyampaian->id) }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')
                                    <tr>
                                        <td class="px-6 py-4 align-top">{{ $item->no_bidang }}</td>
                                        <td class="px-6 py-4 align-top">{{ $item->nama_pemilik }}</td>
                                        <td class="px-6 py-4 align-top">Rp. {{ number_format($item->nilai_kompensasi, 0, ',', '.') }}</td>
                                        <td class="px-6 py-4 align-top">
                                            <select name="status_persetujuan" class="w-full border-gray-300 rounded-md shadow-sm text-sm">
                                                <option value="Setuju" @selected($item->penyampaian->status_persetujuan == 'Setuju')>Setuju</option>
                                                <option value="Menolak" @selected($item->penyampaian->status_persetujuan == 'Menolak')>Menolak</option>
                                            </select>
                                        </td>
                                        <td class="px-6 py-4 align-top">
                                            <a href="{{ Storage::url($item->penyampaian->dokumen_penyampaian) }}" target="_blank" class="text-blue-600 hover:underline text-sm">Lihat</a>
                                            <input type="file" name="dokumen_penyampaian" class="text-xs mt-1">
                                        </td>
                                        <td class="px-6 py-4 align-top">
                                            <button type="submit" class="text-white bg-indigo-600 hover:bg-indigo-700 font-medium rounded-lg text-sm px-3 py-1.5">Update</button>
                                        </td>
                                    </tr>
                                </form>
                            @else
                                {{-- JIKA BELUM ADA DATA PENYAMPAIAN, TAMPILKAN FORM CREATE --}}
                                <form action="{{ route('row.penyampaian.store', ['row' => $row->id, 'penetapanNilai' => $item->id]) }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <tr>
                                        <td class="px-6 py-4 align-top">{{ $item->no_bidang }}</td>
                                        <td class="px-6 py-4 align-top">{{ $item->nama_pemilik }}</td>
                                        <td class="px-6 py-4 align-top">Rp. {{ number_format($item->nilai_kompensasi, 0, ',', '.') }}</td>
                                        <td class="px-6 py-4 align-top">
                                            <select name="status_persetujuan" class="w-full border-gray-300 rounded-md shadow-sm text-sm">
                                                <option value="Setuju">Setuju</option>
                                                <option value="Menolak">Menolak</option>
                                            </select>
                                        </td>
                                        <td class="px-6 py-4 align-top">
                                            <input type="file" name="dokumen_penyampaian" class="text-xs" required>
                                        </td>
                                        <td class="px-6 py-4 align-top">
                                            <button type="submit" class="text-white bg-blue-600 hover:bg-blue-700 font-medium rounded-lg text-sm px-3 py-1.5">Simpan</button>
                                        </td>
                                    </tr>
                                </form>
                            @endif
                        @empty
                            <tr><td colspan="6" class="text-center px-6 py-4 text-gray-500">Tidak ada data penetapan nilai untuk span ini.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
