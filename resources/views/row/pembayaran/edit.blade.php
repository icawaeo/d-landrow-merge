<x-app-layout>
    {{-- Header Halaman --}}
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Edit Data Pembayaran: {{ $row->nama_proyek }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                {{-- Form mengarah ke route 'update' --}}
                    <form action="{{ route('row.pembayaran.update', $pembayaran->id) }}" method="POST" enctype="multipart/form-data" class="p-6">                    @csrf
                    @method('PUT')
                    <div class="space-y-4">
                        {{-- Input Nama Kecamatan dengan nilai lama --}}
                        <div>
                            <label for="nama_kecamatan" class="block font-medium text-sm text-gray-700">Nama Kecamatan</label>
                            <input type="text" name="nama_kecamatan" id="nama_kecamatan" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required value="{{ old('nama_kecamatan', $pembayaran->nama_kecamatan) }}">
                        </div>

                        {{-- Input Status dengan nilai lama --}}
                        <div>
                            <label for="status" class="block font-medium text-sm text-gray-700">Status</label>
                            <select name="status" id="status" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                                <option value="Selesai" @selected(old('status', $pembayaran->status) == 'Selesai')>Selesai</option>
                                <option value="Belum Selesai" @selected(old('status', $pembayaran->status) == 'Belum Selesai')>Belum Selesai</option>
                                <option value="Tertunda" @selected(old('status', $pembayaran->status) == 'Tertunda')>Tertunda</option>
                            </select>
                        </div>

                        {{-- Input Tanggal Pelaksanaan dengan nilai lama --}}
                        <div>
                            <label for="tanggal_pelaksanaan" class="block font-medium text-sm text-gray-700">Tanggal Pelaksanaan</label>
                            <input type="date" name="tanggal_pelaksanaan" id="tanggal_pelaksanaan" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required value="{{ old('tanggal_pelaksanaan', $pembayaran->tanggal_pelaksanaan) }}">
                        </div>

                        {{-- Input Lampiran File (opsional) --}}
                        <div>
                            <label for="lampiran_berita_acara" class="block font-medium text-sm text-gray-700">Lampiran Berita Acara (Kosongkan jika tidak ganti)</label>
                            <input type="file" name="lampiran_berita_acara" id="lampiran_berita_acara" class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                            {{-- Menampilkan file yang sudah ada --}}
                            @if($pembayaran->lampiran_berita_acara)
                            <div class="mt-2">
                                <p class="text-sm text-gray-500">File saat ini: <a href="{{ Storage::url($pembayaran->lampiran_berita_acara) }}" target="_blank" class="text-blue-600 hover:underline">{{ basename($pembayaran->lampiran_berita_acara) }}</a></p>
                            </div>
                            @endif
                        </div>
                    </div>

                    {{-- Tombol Update --}}
                    <div class="flex justify-end mt-6">
                        <button type="submit" class="px-6 py-2 bg-indigo-600 text-white font-semibold rounded-md hover:bg-indigo-700">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
