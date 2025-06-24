<x-app-layout>
    <x-slot name="header">
        {{-- Judul halaman sekarang dinamis, menampilkan data yang diedit --}}
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Edit Data Sosialisasi: {{ $sosialisasi->nama_kecamatan }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                
                {{-- PERUBAHAN 1: Action form mengarah ke route 'update' dan menyertakan ID --}}
                <form action="{{ route('sosialisasi.update', $sosialisasi->id) }}" method="POST" enctype="multipart/form-data" class="p-6">
                    @csrf
                    @method('PUT') {{-- PERUBAHAN 2: Menambahkan method PUT untuk update --}}

                    <div class="space-y-4">
                        <div>
                            <label for="nama_kecamatan" class="block font-medium text-sm text-gray-700">Nama Kecamatan</label>
                            {{-- PERUBAHAN 3: Mengisi 'value' dengan data yang sudah ada --}}
                            <input type="text" name="nama_kecamatan" id="nama_kecamatan" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required value="{{ old('nama_kecamatan', $sosialisasi->nama_kecamatan) }}">
                        </div>
                        <div>
                            <label for="status" class="block font-medium text-sm text-gray-700">Status</label>
                            <select name="status" id="status" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                                {{-- PERUBAHAN 4: Logika untuk memilih opsi yang sesuai dengan data lama --}}
                                <option value="Selesai" {{ old('status', $sosialisasi->status) == 'Selesai' ? 'selected' : '' }}>Selesai</option>
                                <option value="Belum Selesai" {{ old('status', $sosialisasi->status) == 'Belum Selesai' ? 'selected' : '' }}>Belum Selesai</option>
                                <option value="Tertunda" {{ old('status', $sosialisasi->status) == 'Tertunda' ? 'selected' : '' }}>Tertunda</option>
                            </select>
                        </div>
                        <div>
                            <label for="tanggal_pelaksanaan" class="block font-medium text-sm text-gray-700">Tanggal Pelaksanaan</label>
                            <input type="date" name="tanggal_pelaksanaan" id="tanggal_pelaksanaan" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required value="{{ old('tanggal_pelaksanaan', $sosialisasi->tanggal_pelaksanaan) }}">
                        </div>
                        <div>
                            <label for="lampiran_berita_acara" class="block font-medium text-sm text-gray-700">Lampiran Berita Acara (Opsional: Kosongkan jika tidak ingin ganti)</label>
                            <input type="file" name="lampiran_berita_acara" id="lampiran_berita_acara" class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                            
                            {{-- PERUBAHAN 5: Menampilkan link ke file yang sudah ada --}}
                            @if($sosialisasi->lampiran_berita_acara)
                                <div class="mt-2">
                                    <p class="text-sm text-gray-500">File saat ini: 
                                        <a href="{{ Storage::url($sosialisasi->lampiran_berita_acara) }}" target="_blank" class="text-blue-600 hover:underline">
                                            {{ basename($sosialisasi->lampiran_berita_acara) }}
                                        </a>
                                    </p>
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="flex justify-end mt-6">
                        {{-- PERUBAHAN 6: Mengubah teks tombol --}}
                        <button type="submit" class="px-6 py-2 bg-indigo-600 text-white font-semibold rounded-md hover:bg-indigo-700">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>