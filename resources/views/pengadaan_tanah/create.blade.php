<x-app-layout>
    {{-- Bagian Header: Diisi dengan tombol Kembali dan judul --}}
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-4">
                {{-- Tombol Kembali --}}
                <a href="{{ route('homepage') }}" class="text-gray-500 hover:text-gray-700">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                </a>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    Kembali
                </h2>
            </div>
        </div>
    </x-slot>

    {{-- Konten Utama Halaman --}}
    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 md:p-8">
                    {{-- Judul Form --}}
                    <h3 class="text-2xl font-bold text-gray-800 border-b-2 border-dotted pb-4 mb-6">{{ $judul }}</h3>
                    
                    {{-- Form --}}
                    <form action="{{ route('pengadaan_tanah.store') }}" method="POST">
                        @csrf
                        {{-- Menyimpan kategori secara tersembunyi --}}
                        <input type="hidden" name="kategori" value="{{ $kategori }}">

                        <div class="space-y-6">
                            {{-- Baris NAMA PROYEK --}}
                            <div class="grid grid-cols-3 gap-4 items-center">
                                <label for="nama_proyek" class="font-semibold text-gray-700">NAMA PROYEK</label>
                                <div class="col-span-2 flex items-center gap-4">
                                    <span class="font-semibold">:</span>
                                    <input type="text" name="nama_proyek" id="nama_proyek" required class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                </div>
                            </div>
                            
                            {{-- Baris JUMLAH TOWER --}}
                            <div class="grid grid-cols-3 gap-4 items-center">
                                <label for="jumlah_tower" class="font-semibold text-gray-700">JUMLAH TOWER</label>
                                <div class="col-span-2 flex items-center gap-4">
                                    <span class="font-semibold">:</span>
                                    <input type="number" name="jumlah_tower" id="jumlah_tower" class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                </div>
                            </div>
                            
                            {{-- Baris PROVINSI --}}
                            <div class="grid grid-cols-3 gap-4 items-center">
                                <label for="provinsi" class="font-semibold text-gray-700">PROVINSI</label>
                                <div class="col-span-2 flex items-center gap-4">
                                    <span class="font-semibold">:</span>
                                    {{-- Untuk sementara kita gunakan input teks biasa --}}
                                    <input type="text" name="provinsi" id="provinsi" class="flex-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                </div>
                            </div>
                            
                            {{-- Baris KABUPATEN --}}
                            <div class="grid grid-cols-3 gap-4 items-center">
                                <label for="kabupaten" class="font-semibold text-gray-700">KABUPATEN</label>
                                <div class="col-span-2 flex items-center gap-4">
                                    <span class="font-semibold">:</span>
                                    <input type="text" name="kabupaten" id="kabupaten" class="flex-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                </div>
                            </div>

                            {{-- Baris KECAMATAN --}}
                            <div class="grid grid-cols-3 gap-4 items-center">
                                <label for="kecamatan" class="font-semibold text-gray-700">KECAMATAN</label>
                                <div class="col-span-2 flex items-center gap-4">
                                    <span class="font-semibold">:</span>
                                    <input type="text" name="kecamatan" id="kecamatan" class="flex-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                </div>
                            </div>
                            
                            {{-- Baris DESA --}}
                            <div class="grid grid-cols-3 gap-4 items-center">
                                <label for="desa" class="font-semibold text-gray-700">DESA</label>
                                <div class="col-span-2 flex items-center gap-4">
                                    <span class="font-semibold">:</span>
                                    <input type="text" name="desa" id="desa" class="flex-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                </div>
                            </div>
                        </div>

                        {{-- Tombol Create --}}
                        <div class="flex justify-end mt-8">
                            <button type="submit" class="px-8 py-2 bg-gray-800 text-white font-bold rounded-md hover:bg-gray-700 shadow-lg">
                                BUAT PROYEK
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>