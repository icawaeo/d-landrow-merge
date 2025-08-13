@props([
    'proyek' => null,
    'tahapan' => null,
    'tambahDataUrl' => null
])

@php
    if ($proyek) {
        $status = $proyek->status_persetujuan;
        $statusText = '';
        $statusColor = '';

        switch (true) {
            case str_starts_with($status, 'ditolak'):
                $statusText = 'Ditolak';
                $statusColor = 'bg-red-200 text-red-800';
                break;

            case $status === 'menunggu_admin_1':
                $statusText = 'Sudah Diajukan';
                $statusColor = 'bg-yellow-200 text-yellow-800';
                break;
            
            case $status === 'menunggu_admin_2':
                $statusText = 'Menunggu Admin 2';
                $statusColor = 'bg-yellow-200 text-yellow-800';
                break;
            
            case $status === 'menunggu_admin_3':
                $statusText = 'Menunggu Admin 3';
                $statusColor = 'bg-yellow-200 text-yellow-800';
                break;
            
            case $status === 'disetujui':
                $statusText = 'Disetujui';
                $statusColor = 'bg-green-200 text-green-800';
                break;

            default:
                $statusText = 'Belum Diajukan';
                $statusColor = 'bg-gray-200 text-gray-800';
        }
    }
@endphp

@php
    // Menambahkan kembali logika read-only untuk tombol
    $isReadOnly = true; // Defaultnya read-only
    if ($proyek) {
        $isReadOnly = !($proyek->status_persetujuan === 'belum_diajukan' || str_starts_with($proyek->status_persetujuan, 'ditolak'));
    }
@endphp


<div class="bg-white shadow-sm">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div {{ $attributes->merge(['class' => 'py-6 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4']) }}>
            <div>
                <h2 class="text-2xl font-bold text-gray-800 leading-tight">
                    {{ $tahapan }}
                </h2>

                @if($proyek)
                    <div class="mt-1 flex items-center gap-3">
                        <span class="text-sm text-gray-500 font-medium">{{ $proyek->nama_proyek }}</span>
                        <span class="text-xs font-semibold px-2.5 py-0.5 rounded-full {{ $statusColor }}">
                            {{ $statusText }}
                        </span>
                    </div>
                @endif
            </div>

            {{-- Wadah untuk semua tombol aksi --}}
            <div class="flex items-center space-x-3 flex-shrink-0">
                {{-- Tombol Export PDF Pembayaran - Pengadaan Tanah --}}
                @if($proyek && (Route::currentRouteName() == 'pembayaran.index' || Route::currentRouteName() == 'pembayaran.edit') && !$isReadOnly)
                    <a href="{{ route('pembayaran.exportPdf', $proyek->id) }}" target="_blank" class="inline-flex items-center px-4 py-2 bg-red-600 text-white font-semibold text-sm rounded-md hover:bg-red-700 transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                        </svg>
                        Export PDF
                    </a>
                @endif

                {{-- Tombol Export PDF Penetapan Nilai - ROW --}}
                @if($proyek && Route::currentRouteName() == 'row.penetapan-nilai.index' && !$isReadOnly)
                    <a href="{{ route('row.penetapan-nilai.exportPdf', $proyek->id) }}" target="_blank" class="inline-flex items-center px-4 py-2 bg-red-600 text-white font-semibold text-sm rounded-md hover:bg-red-700 transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" /></svg>
                        Export PDF
                    </a>
                @endif

                {{-- Tombol Export PDF Pembayaran - ROW --}}
                @if($proyek && Route::currentRouteName() == 'row.pembayaran-menu.index' && !$isReadOnly)
                    <a href="{{ route('row.pembayaran-menu.exportPdf', $proyek->id) }}" target="_blank" class="inline-flex items-center px-4 py-2 bg-red-600 text-white font-semibold text-sm rounded-md hover:bg-red-700 transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" /></svg>
                        Export PDF
                    </a>
                @endif

                {{-- Tombol Tambah Data --}}
                @if($tambahDataUrl)
                    <a href="{{ $tambahDataUrl }}" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white font-semibold text-sm rounded-md hover:bg-blue-700 transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                        Tambah Data
                    </a>
                @endif
            </div>
        </div>
    </div>
</div>