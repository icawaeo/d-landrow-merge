<x-app-layout>
    @php
        $isReadOnly = !($proyek->status_persetujuan === 'belum_diajukan' || str_starts_with($proyek->status_persetujuan, 'ditolak'));
    @endphp

    @push('content-header')
        <x-content-header
            :proyek="$proyek"
            tahapan="Pembayaran"
        />
    @endpush

    <div class="py-2">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <div class="overflow-x-auto">
                    <table class="min-w-full bg-white">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">No.</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">No Tip</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nama Pemilik</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Desa</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nilai</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status Bayar</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tgl Bayar</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Bukti Dokumen</th>
                                <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @foreach($pembayaranItems as $item)
                                {{-- Logika untuk beralih antara mode edit dan mode normal --}}
                                @if(isset($itemToEdit) && $itemToEdit->id === $item->id)
                                    {{-- MODE EDIT: Tampilkan baris sebagai form --}}
                                    <form action="{{ route('pembayaran.update', $itemToEdit->id) }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        @method('PUT')
                                        <tr class="bg-yellow-50">
                                            <td class="px-4 py-2">{{ $loop->iteration }}</td>
                                            <td class="px-4 py-2">{{ $itemToEdit->no_tip }}</td>
                                            <td class="px-4 py-2">{{ $itemToEdit->nama_pemilik }}</td>
                                            <td class="px-4 py-2">{{ $itemToEdit->desa }}</td>
                                            <td class="px-4 py-2">Rp. {{ number_format($itemToEdit->nilai, 0, ',', '.') }}</td>
                                            <td class="px-2 py-1">
                                                <select name="status_pembayaran" class="w-full border-gray-300 rounded-md shadow-sm text-sm">
                                                    <option value="">--Pilih--</option>
                                                    <option value="TERBAYAR" @selected(old('status_pembayaran', $itemToEdit->status_pembayaran) == 'TERBAYAR')>TERBAYAR</option>
                                                    <option value="PROSES" @selected(old('status_pembayaran', $itemToEdit->status_pembayaran) == 'PROSES')>PROSES</option>
                                                    <option value="MENOLAK" @selected(old('status_pembayaran', $itemToEdit->status_pembayaran) == 'MENOLAK')>MENOLAK</option>
                                                </select>
                                            </td>
                                            <td class="px-2 py-1">
                                                <input type="date" name="tanggal_pembayaran" value="{{ old('tanggal_pembayaran', $itemToEdit->tanggal_pembayaran) }}" class="w-full border-gray-300 rounded-md shadow-sm text-sm">
                                            </td>
                                            <td class="px-2 py-1">
                                                <input type="file" name="bukti_pembayaran" class="text-xs w-full">
                                                @if ($itemToEdit->bukti_pembayaran)
                                                    <a href="{{ Storage::url($itemToEdit->bukti_pembayaran) }}" target="_blank" class="text-blue-600 text-xs hover:underline block mt-1">Lihat File</a>
                                                @endif
                                            </td>
                                            <td class="px-4 py-2">
                                                <div class="flex items-center space-x-2">
                                                    <button type="submit" class="text-white bg-green-600 hover:bg-green-700 font-medium rounded-lg text-sm px-3 py-1.5">Update</button>
                                                    <a href="{{ route('pembayaran.index', $proyek->id) }}" class="text-gray-600 hover:text-gray-900">Batal</a>
                                                </div>
                                            </td>
                                        </tr>
                                    </form>
                                @else
                                    {{-- MODE NORMAL: Tampilkan data seperti biasa --}}
                                    <tr>
                                        <td class="px-4 py-2">{{ $loop->iteration }}</td>
                                        <td class="px-4 py-2">{{ $item->no_tip }}</td>
                                        <td class="px-4 py-2">{{ $item->nama_pemilik }}</td>
                                        <td class="px-4 py-2">{{ $item->desa }}</td>
                                        <td class="px-4 py-2">Rp. {{ number_format($item->nilai, 0, ',', '.') }}</td>
                                        <td class="px-4 py-2">{{ $item->status_pembayaran ?? 'Belum Diproses' }}</td>
                                        <td class="px-4 py-2">{{ $item->tanggal_pembayaran ? \Carbon\Carbon::parse($item->tanggal_pembayaran)->format('d/m/Y') : '-' }}</td>
                                        <td class="px-4 py-2">
                                            @if ($item->bukti_pembayaran)
                                                <a href="{{ Storage::url($item->bukti_pembayaran) }}" target="_blank" class="text-blue-600 hover:underline">Lihat</a>
                                            @else
                                                <span class="text-gray-400">Kosong</span>
                                            @endif
                                        </td>
                                        <td class="px-4 py-2 text-sm font-medium text-center">
                                            <div class="flex justify-center items-center space-x-3">
                                                {{-- Tombol Edit --}}
                                                @if(!$isReadOnly)
                                                    <a href="{{ route('pembayaran.edit', $item->id) }}" class="text-gray-500 hover:text-blue-600" title="Edit">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5M18.5 2.5a2.121 2.121 0 113 3L12 15l-4 1 1-4 9.5-9.5z"/>
                                                        </svg>
                                                    </a>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>