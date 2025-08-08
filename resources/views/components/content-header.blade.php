@props([
    'proyek' => null,
    'tahapan' => null,
    'tambahDataUrl' => null
])

<div class="bg-white shadow-sm">

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <div {{ $attributes->merge(['class' => 'py-6 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4']) }}>
            <div>
                {{-- Breadcrumb Navigation --}}
                {{-- <nav class="flex items-center text-sm font-medium text-gray-500 hover:text-gray-700 mb-1">
                    @if($proyek)
                        <a href="{{ route('homepage') }}">Homepage</a>
                        <span class="mx-2">/</span>
                        <span>{{ $proyek->nama_proyek }}</span>
                        <span class="mx-2">/</span>
                        <span class="text-gray-800 font-semibold">{{ $tahapan }}</span>
                    @else
                        <span class="text-gray-800 font-semibold">{{ $tahapan }}</span>
                    @endif
                </nav> --}}

                <h2 class="text-2xl font-bold text-gray-800 leading-tight">
                    {{ $tahapan }}{{ $proyek ? ': ' . $proyek->nama_proyek : '' }}
                </h2>
            </div>

            @if($tambahDataUrl)
                <a href="{{ $tambahDataUrl }}" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white font-semibold text-sm rounded-md hover:bg-blue-700 transition flex-shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    Tambah Data
                </a>
            @endif
        </div>

    </div>
</div>