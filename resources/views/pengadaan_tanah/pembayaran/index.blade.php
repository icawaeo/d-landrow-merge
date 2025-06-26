<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">PEMBAYARAN: {{ $proyek->nama_proyek }}</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <div class="overflow-x-auto">
                    <table class="min-w-full bg-white">
                        <thead>
                            <tr>
                                <th class="px-2 py-3 text-left text-xs font-medium text-gray-500 uppercase">No.</th>
                                <th class="px-2 py-3 text-left text-xs font-medium text-gray-500 uppercase">No Tip</th>
                                <th class="px-2 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nama Pemilik</th>
                                <th class="px-2 py-3 text-left text-xs font-medium text-gray-500 uppercase">Desa</th>
                                <th class="px-2 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nilai</th>
                                <th class="px-2 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                                <th class="px-2 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tgl Bayar</th>
                                <th class="px-2 py-3 text-left text-xs font-medium text-gray-500 uppercase">Bukti Dokumen</th>
                                <th class="px-2 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @foreach($pembayaranItems as $item)
                                <tr>
                                    <form action="{{ route('pembayaran.update', $item->id) }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <td class="px-2 py-2">{{ $loop->iteration }}</td>
                                        <td class="px-2 py-2">{{ $item->no_tip }}</td>
                                        <td class="px-2 py-2">{{ $item->nama_pemilik }}</td>
                                        <td class="px-2 py-2">{{ $item->desa }}</td>
                                        <td class="px-2 py-2">Rp. {{ number_format($item->nilai, 0, ',', '.') }}</td>
                                        <td class="px-2 py-2">
                                            <select name="status_pembayaran" class="w-full border-gray-300 rounded-md shadow-sm text-sm">
                                                <option value="">--Pilih--</option>
                                                <option value="TERBAYAR" @selected($item->status_pembayaran == 'TERBAYAR')>TERBAYAR</option>
                                                <option value="PROSES" @selected($item->status_pembayaran == 'PROSES')>PROSES</option>
                                                <option value="MENOLAK" @selected($item->status_pembayaran == 'MENOLAK')>MENOLAK</option>
                                            </select>
                                        </td>
                                        <td class="px-2 py-2">
                                            <input type="date" name="tanggal_pembayaran" value="{{ $item->tanggal_pembayaran }}" class="w-full border-gray-300 rounded-md shadow-sm text-sm">
                                        </td>
                                        <td class="px-2 py-2">
                                            @if ($item->bukti_pembayaran)
                                                <a href="{{ Storage::url($item->bukti_pembayaran) }}" target="_blank" class="text-blue-600 hover:underline text-sm">Lihat</a>
                                            @endif
                                            <input type="file" name="bukti_pembayaran" class="text-xs">
                                        </td>
                                        <td class="px-2 py-2">
                                            <button type="submit" class="text-white bg-blue-600 hover:bg-blue-700 font-medium rounded-lg text-sm px-3 py-1.5">Simpan</button>
                                        </td>
                                    </form>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>