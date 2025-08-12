<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Detail Proyek: ') }} {{ $project->nama_proyek }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <a href="{{ route('admin.dashboard') }}" class="inline-block mb-6 px-4 py-2 bg-gray-500 text-white text-xs font-semibold rounded-md hover:bg-gray-600">
                        &larr; Kembali ke Dashboard
                    </a>

                    <h3 class="text-lg font-medium text-gray-900 border-b pb-2">Informasi Umum Proyek</h3>
                    <div class="mt-4 grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <dt class="font-medium text-gray-500">Nama Proyek</dt>
                            <dd class="text-gray-900">{{ $project->nama_proyek }}</dd>
                        </div>
                        <div>
                            <dt class="font-medium text-gray-500">Tipe Proyek</dt>
                            <dd class="text-gray-900">{{ ucwords(str_replace('-', ' ', $type)) }}</dd>
                        </div>
                        <div>
                            <dt class="font-medium text-gray-500">Status Persetujuan</dt>
                            <dd>
                                @if ($project->status_persetujuan == 'disetujui')
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                        Disetujui Penuh
                                    </span>
                                @elseif (Str::startsWith($project->status_persetujuan, 'ditolak'))
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                        Ditolak
                                    </span>
                                @else
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                        {{ ucwords(str_replace('_', ' ', $project->status_persetujuan)) }}
                                    </span>
                                @endif
                            </dd>
                        </div>
                        @if (Str::startsWith($project->status_persetujuan, 'ditolak') && $project->catatan_penolakan)
                            <div>
                                <dt class="font-medium text-gray-500">Catatan Penolakan</dt>
                                <dd class="text-red-600">{{ $project->catatan_penolakan }}</dd>
                            </div>
                        @endif
                    </div>
                    
                    <h3 class="text-lg font-medium text-gray-900 border-b pb-2 mt-8">Dokumen Terlampir</h3>
                    <div class="mt-4">
                        <ul class="list-disc list-inside space-y-2">
                            @php
                                $documents = $type === 'pengadaan-tanah' ? $project->dokumenHasils : $project->dokumenROW; // [ BENAR ]
                            @endphp

                            @forelse ($documents as $doc)
                                <li>
                                    <a href="{{ asset('storage/' . $doc->path) }}" target="_blank" class="text-blue-600 hover:text-blue-800 underline">
                                        {{ $doc->nama_dokumen ?? basename($doc->path) }}
                                    </a>
                                </li>
                            @empty
                                <li class="text-gray-500">Tidak ada dokumen yang diunggah.</li>
                            @endforelse
                        </ul>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>