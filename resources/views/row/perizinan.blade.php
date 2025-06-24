<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight flex items-center gap-4">
            <a href="{{ route('homepage') }}" class="text-gray-500 hover:text-gray-700">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
            </a>
            <span>Perizinan untuk Proyek ROW: {{ $proyek->nama_proyek }}</span>
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            {{-- Tampilkan Pesan Sukses atau Error --}}
            @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif
            @if ($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <strong class="font-bold">Gagal!</strong>
                    <span class="block sm:inline">Silakan periksa input Anda. File yang wajib harus diisi.</span>
                </div>
            @endif

            <div class="bg-white shadow-sm sm:rounded-lg">
                <form action="{{ route('row.perizinan.store', $proyek->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="p-6 space-y-6">
                        @php
                            $izinList = [
                                ['name' => 'izin_lingkungan', 'label' => 'Izin Lingkungan', 'required' => true],
                                ['name' => 'izin_rt_rw', 'label' => 'Izin RT/RW', 'required' => true],
                                ['name' => 'izin_prinsip', 'label' => 'Izin Prinsip', 'required' => true],
                                ['name' => 'izin_penetapan_lokasi', 'label' => 'Izin Penetapan Lokasi', 'required' => false],
                            ];
                        @endphp

                        @foreach ($izinList as $izin)
                        <div class="border-b pb-4">
                           <div class="flex items-center justify-between">
                                <label for="{{ $izin['name'] }}_input" class="text-gray-700 font-medium cursor-pointer">
                                    {{ strtoupper($izin['label']) }}
                                    @if (empty($perizinan->{$izin['name']}) && $izin['required']) 
                                        <span class="text-red-600 font-bold">*</span> 
                                    @endif
                                </label>
                                <div class="flex items-center space-x-4">
                                    @if ($perizinan->{$izin['name']})
                                        <a href="{{ Storage::url($perizinan->{$izin['name']}) }}" target="_blank" class="text-sm text-green-600 hover:underline">Lihat File</a>
                                    @endif
                                    <span id="{{ $izin['name'] }}_filename" class="text-sm text-gray-500 max-w-[120px] truncate"></span>
                                    <label for="{{ $izin['name'] }}_input" class="cursor-pointer px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white text-sm rounded-md transition">
                                        {{ $perizinan->{$izin['name']} ? 'Ganti File' : 'Upload Doc' }}
                                    </label>
                                    <input type="file" name="{{ $izin['name'] }}" class="hidden" id="{{ $izin['name'] }}_input" onchange="document.getElementById('{{ $izin['name'] }}_filename').textContent = this.files[0].name">
                                </div>
                            </div>
                            @error($izin['name'])
                                <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                            @enderror
                        </div>
                        @endforeach
                    </div>

                    <div class="px-6 py-4 bg-gray-50 border-t flex justify-end">
                        <button type="submit" class="px-6 py-2 bg-gray-800 text-white font-bold rounded-md hover:bg-gray-700">
                            Save
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>