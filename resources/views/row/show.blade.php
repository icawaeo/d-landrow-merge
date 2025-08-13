<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Detail Proyek ROW') }}
            </h2>
            <a href="{{ url()->previous() }}" class="px-4 py-2 bg-gray-200 text-gray-800 rounded-md hover:bg-gray-300">
                &larr; Kembali
            </a>
        </div>
    </x-slot>

    <div class="py-2">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            {{-- KARTU DETAIL PROYEK --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-semibold border-b pb-3 mb-4">{{ $row->nama_proyek }}</h3>
                    <dl class="grid grid-cols-1 sm:grid-cols-2 gap-x-6 gap-y-4">
                        <div class="sm:col-span-1">
                            <dt class="text-sm font-medium text-gray-500">Jumlah Tower</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $row->jumlah_tower }}</dd>
                        </div>
                        <div class="sm:col-span-1">
                            <dt class="text-sm font-medium text-gray-500">Provinsi</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $row->provinsi }}</dd>
                        </div>
                        <div class="sm:col-span-1">
                            <dt class="text-sm font-medium text-gray-500">Kabupaten/Kota</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $row->kabupaten }}</dd>
                        </div>
                        <div class="sm:col-span-1">
                            <dt class="text-sm font-medium text-gray-500">Kecamatan</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $row->kecamatan }}</dd>
                        </div>
                        <div class="sm:col-span-1">
                            <dt class="text-sm font-medium text-gray-500">Desa/Kelurahan</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $row->desa }}</dd>
                        </div>
                    </dl>
                </div>
            </div>

            {{-- NAVIGASI TAHAPAN PROYEK --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-semibold border-b pb-3 mb-4">Tahapan Proyek ROW</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        
                        {{-- Link ke setiap tahapan ROW --}}
                        <a href="{{ route('row.perizinan.index', $row->id) }}" class="p-4 bg-gray-50 rounded-lg border hover:bg-gray-100 hover:shadow-md transition">
                            <h4 class="font-semibold text-gray-800">1. Perizinan</h4>
                            <p class="text-sm text-gray-600">Lihat data dan dokumen perizinan ROW.</p>
                        </a>
                        <a href="{{ route('row.sosialisasi.index', $row->id) }}" class="p-4 bg-gray-50 rounded-lg border hover:bg-gray-100 hover:shadow-md transition">
                            <h4 class="font-semibold text-gray-800">2. Sosialisasi</h4>
                            <p class="text-sm text-gray-600">Lihat data dan dokumen sosialisasi ROW.</p>
                        </a>
                        <a href="{{ route('row.inventarisasi.index', $row->id) }}" class="p-4 bg-gray-50 rounded-lg border hover:bg-gray-100 hover:shadow-md transition">
                            <h4 class="font-semibold text-gray-800">3. Inventarisasi</h4>
                            <p class="text-sm text-gray-600">Lihat data dan dokumen inventarisasi ROW.</p>
                        </a>
                        <a href="{{ route('row.musyawarah_sub.index', $row->id) }}" class="p-4 bg-gray-50 rounded-lg border hover:bg-gray-100 hover:shadow-md transition">
                            <h4 class="font-semibold text-gray-800">4. Musyawarah</h4>
                            <p class="text-sm text-gray-600">Lihat data dan dokumen musyawarah ROW.</p>
                        </a>
                        <a href="{{ route('row.pembayaran.index', $row->id) }}" class="p-4 bg-gray-50 rounded-lg border hover:bg-gray-100 hover:shadow-md transition">
                            <h4 class="font-semibold text-gray-800">5. Pembayaran</h4>
                            <p class="text-sm text-gray-600">Lihat data dan dokumen pembayaran ROW.</p>
                        </a>

                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>