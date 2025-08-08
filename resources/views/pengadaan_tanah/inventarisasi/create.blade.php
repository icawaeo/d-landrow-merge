<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Tambah Data Inventarisasi untuk: {{ $proyek->nama_proyek }}</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <form action="{{ route('inventarisasi.store', $proyek->id) }}" method="POST" enctype="multipart/form-data" class="p-6">
                    @csrf
                    <div class="space-y-4">
                        <div>
                            <label for="nama_kecamatan" class="block font-medium text-sm text-gray-700">Nama Kecamatan</label>
                            <input type="text" name="nama_kecamatan" id="nama_kecamatan" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                        </div>
                        <div>
                            <label for="status" class="block font-medium text-sm text-gray-700">Status</label>
                            <select name="status" id="status" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                                <option value="Selesai">Selesai</option>
                                <option value="Belum Selesai">Belum Selesai</option>
                                <option value="Tertunda">Tertunda</option>
                            </select>
                        </div>
                        <div>
                            <label for="tanggal_pelaksanaan" class="block font-medium text-sm text-gray-700">Tanggal Pelaksanaan</label>
                            <input type="date" name="tanggal_pelaksanaan" id="tanggal_pelaksanaan" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                        </div>
                        <div>
                            <label for="lampiran_berita_acara" class="block font-medium text-sm text-gray-700">Lampiran Berita Acara</label>
                            <input type="file" name="lampiran_berita_acara" id="lampiran_berita_acara" class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                        </div>
                    </div>
                    <div class="flex justify-end mt-6 gap-4">
                        <a href="{{ route('inventarisasi.index', $proyek->id) }}" class="px-6 py-2 bg-gray-300 text-gray-700 font-semibold rounded-md hover:bg-gray-400">Batal</a>
                        <button type="submit" class="px-6 py-2 bg-gray-800 text-white font-semibold rounded-md hover:bg-gray-700">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>