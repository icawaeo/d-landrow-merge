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
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                    <input type="text" name="no_surat" placeholder="Nama Surat" class="border border-gray-300 rounded-md px-3 py-2 text-sm w-full" required>
                    <input type="text" name="total_tip_luas" placeholder="Total TIP / Luas" class="border border-gray-300 rounded-md px-3 py-2 text-sm w-full" required>
                    <input type="date" name="tgl_surat" class="border border-gray-300 rounded-md px-3 py-2 text-sm w-full" required>
                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 text-sm w-full">Simpan</button>
                </div>
            </form>
        </div>

        <!-- Tabel Dokumen -->
        <div class="bg-white p-4 sm:p-6 rounded-lg shadow overflow-x-auto">
            <table class="min-w-full text-sm text-gray-700">
                <thead class="bg-gray-100 text-xs uppercase text-gray-600 tracking-wider">
                    <tr>
                        <th class="px-4 py-3 text-left">No.</th>
                        <th class="px-4 py-3 text-left">Surat</th>
                        <th class="px-4 py-3 text-left">Total TIP/Luas</th>
                        <th class="px-4 py-3 text-left">Tanggal Surat</th>
                        <th class="px-4 py-3 text-left">Dokumen</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach ($dokumen as $index => $item)
                        <tr>
                            <td class="px-4 py-2">{{ $index + 1 }}</td>
                            <td class="px-4 py-2">{{ $item->no_surat }}</td>
                            <td class="px-4 py-2">{{ $item->total_tip_luas }}</td>
                            <td class="px-4 py-2">{{ $item->tgl_surat }}</td>
                            <td class="px-4 py-2">
                                <form action="{{ route('dokumenhasil.store') }}" method="POST">
                                    @csrf
                                    
                                    {{-- TAMBAHKAN INPUT TERSEMBUNYI INI --}}
                                    <input type="hidden" name="pengadaan_tanah_id" value="{{ $proyek->id }}">

                                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                                        <input type="text" name="no_surat" placeholder="Nama Surat" class="border border-gray-300 rounded-md px-3 py-2 text-sm w-full" required>
                                        <input type="text" name="total_tip_luas" placeholder="Total TIP / Luas" class="border border-gray-300 rounded-md px-3 py-2 text-sm w-full" required>
                                        <input type="date" name="tgl_surat" class="border border-gray-300 rounded-md px-3 py-2 text-sm w-full" required>
                                        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 text-sm w-full">Simpan</button>
                                    </div>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
