<x-app-layout>
    {{-- Header dengan judul dinamis dan tombol Kembali --}}
    <x-slot name="header">
        <div class="flex items-center gap-4">
            <a href="{{ route('homepage') }}" class="text-gray-500 hover:text-gray-700">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
            </a>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{-- Judulnya sekarang dinamis --}}
                Edit Data: {{ $proyek->nama_proyek }}
            </h2>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 md:p-8">
                    
                    {{-- Form ini sekarang mengarah ke route 'update' --}}
                    <form action="{{ route('pengadaan_tanah.update', $proyek->id) }}" method="POST">
                        @csrf
                        @method('PUT') {{-- PENTING: Method untuk request UPDATE --}}

                        <div class="space-y-6">
                            {{-- Baris NAMA PROYEK --}}
                            <div class="grid grid-cols-3 gap-4 items-center">
                                <label for="nama_proyek" class="font-semibold text-gray-700">NAMA PROYEK</label>
                                <div class="col-span-2 flex items-center gap-4">
                                    <span class="font-semibold">:</span>
                                    {{-- value diisi dengan data lama dari $proyek --}}
                                    <input type="text" name="nama_proyek" id="nama_proyek" required value="{{ old('nama_proyek', $proyek->nama_proyek) }}" class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                </div>
                            </div>
                            
                            {{-- Baris JUMLAH TOWER --}}
                            <div class="grid grid-cols-3 gap-4 items-center">
                                <label for="jumlah_tower" class="font-semibold text-gray-700">JUMLAH TOWER</label>
                                <div class="col-span-2 flex items-center gap-4">
                                    <span class="font-semibold">:</span>
                                    <input type="number" name="jumlah_tower" id="jumlah_tower" value="{{ old('jumlah_tower', $proyek->jumlah_tower) }}" class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                </div>
                            </div>
                            
                            {{-- Baris PROVINSI --}}
                            <div class="grid grid-cols-3 gap-4 items-center">
                                <label for="provinsi" class="font-semibold text-gray-700">PROVINSI</label>
                                <div class="col-span-2 flex items-center gap-4">
                                    <span class="font-semibold">:</span>
                                    <input type="text" name="provinsi" id="provinsi" value="{{ old('provinsi', $proyek->provinsi) }}" class="flex-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                </div>
                            </div>
                            
                            {{-- Baris KABUPATEN --}}
                            <div class="grid grid-cols-3 gap-4 items-center">
                                <label for="kabupaten" class="font-semibold text-gray-700">KABUPATEN</label>
                                <div class="col-span-2 flex items-center gap-4">
                                    <span class="font-semibold">:</span>
                                    <input type="text" name="kabupaten" id="kabupaten" value="{{ old('kabupaten', $proyek->kabupaten) }}" class="flex-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                </div>
                            </div>

                            {{-- Baris KECAMATAN --}}
                            <div class="grid grid-cols-3 gap-4 items-center">
                                <label for="kecamatan" class="font-semibold text-gray-700">KECAMATAN</label>
                                <div class="col-span-2 flex items-center gap-4">
                                    <span class="font-semibold">:</span>
                                    <input type="text" name="kecamatan" id="kecamatan" value="{{ old('kecamatan', $proyek->kecamatan) }}" class="flex-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                </div>
                            </div>
                            
                            {{-- Baris DESA --}}
                            <div class="grid grid-cols-3 gap-4 items-center">
                                <label for="desa" class="font-semibold text-gray-700">DESA</label>
                                <div class="col-span-2 flex items-center gap-4">
                                    <span class="font-semibold">:</span>
                                    <input type="text" name="desa" id="desa" value="{{ old('desa', $proyek->desa) }}" class="flex-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                </div>
                            </div>
                        </div>

                        {{-- Tombol Update --}}
                        <div class="flex justify-end mt-8">
                            <button type="submit" class="px-8 py-2 bg-indigo-600 text-white font-bold rounded-md hover:bg-indigo-700 shadow-lg">
                                UPDATE
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>