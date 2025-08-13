<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Detail Proyek: ') }} {{ $project->nama_proyek }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 md:p-8 text-gray-900 space-y-8">

                    <div>
                        <div class="flex justify-between items-center">
                            <h3 class="text-xl font-bold text-gray-800">Informasi Umum</h3>
                            <a href="{{ route('admin.dashboard') }}" class="px-4 py-2 bg-gray-500 text-white text-xs font-semibold rounded-md hover:bg-gray-600">
                                &larr; Kembali ke Dashboard
                            </a>
                        </div>
                        <hr class="my-4">
                        <dl class="grid grid-cols-1 md:grid-cols-3 gap-x-6 gap-y-4 text-sm">
                            <div>
                                <dt class="font-medium text-gray-500">Nama Proyek</dt>
                                <dd class="mt-1 text-gray-900">{{ $project->nama_proyek }}</dd>
                            </div>
                            <div>
                                <dt class="font-medium text-gray-500">Tipe Proyek</dt>
                                <dd class="mt-1 text-gray-900">{{ ucwords(str_replace('-', ' ', $type)) }}</dd>
                            </div>
                            <div>
                                <dt class="font-medium text-gray-500">Status</dt>
                                <dd class="mt-1">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full @if ($project->status_persetujuan == 'disetujui') bg-green-100 text-green-800 @elseif (Str::startsWith($project->status_persetujuan, 'ditolak')) bg-red-100 text-red-800 @else bg-blue-100 text-blue-800 @endif">
                                        {{ ucwords(str_replace('_', ' ', $project->status_persetujuan)) }}
                                    </span>
                                </dd>
                            </div>
                            @if (Str::startsWith($project->status_persetujuan, 'ditolak') && $project->catatan_penolakan)
                                <div class="md:col-span-3">
                                    <dt class="font-medium text-gray-500">Catatan Penolakan</dt>
                                    <dd class="text-red-600 mt-1">{{ $project->catatan_penolakan }}</dd>
                                </div>
                            @endif
                        </dl>
                    </div>

                    @if ($type === 'pengadaan-tanah')
                        
                        <div class="pt-6">
                            <h3 class="text-xl font-bold text-gray-800">Perizinan</h3>
                            <hr class="my-4">
                            @if($project->perizinan)
                                @php
                                    $perizinan = $project->perizinan;
                                    $izinList = [
                                        ['name' => 'izin_lingkungan', 'label' => 'Izin Lingkungan'],
                                        ['name' => 'ikkpr', 'label' => 'IKKPR'],
                                        ['name' => 'izin_prinsip', 'label' => 'Izin Prinsip'],
                                        ['name' => 'izin_penetapan_lokasi', 'label' => 'Izin Penetapan Lokasi'],
                                    ];
                                @endphp
                                <div class="space-y-3">
                                @foreach($izinList as $izin)
                                    <div class="flex justify-between items-center p-3 border rounded-md text-sm">
                                        <dt class="font-medium text-gray-600">{{ $izin['label'] }}</dt>
                                        <dd>
                                            @if(!empty($perizinan->{$izin['name']}))
                                                <a href="{{ Storage::url($perizinan->{$izin['name']}) }}" target="_blank" class="text-blue-600 hover:underline">Lihat File</a>
                                            @else
                                                <span class="text-gray-500">Belum diinput</span>
                                            @endif
                                        </dd>
                                    </div>
                                @endforeach
                                </div>
                            @else
                                <p class="text-sm text-gray-500">Data perizinan belum diinput.</p>
                            @endif
                        </div>

                        <div class="pt-6">
                            <h3 class="text-xl font-bold text-gray-800">Tahapan</h3>
                            <hr class="my-4">
                            
                            <h4 class="text-lg font-semibold text-gray-700">A. Sosialisasi</h4>
                            @forelse($project->sosialisasis as $item)
                                <dl class="grid grid-cols-1 md:grid-cols-4 gap-x-6 gap-y-4 text-sm mt-2 mb-4 p-4 border rounded-md">
                                    <div>
                                        <dt class="font-medium text-gray-500">Kecamatan</dt>
                                        <dd class="mt-1">{{ $item->nama_kecamatan ?? '-' }}</dd>
                                    </div>
                                    <div>
                                        <dt class="font-medium text-gray-500">Status</dt>
                                        <dd class="mt-1">{{ $item->status ?? '-' }}</dd>
                                    </div>
                                    <div>
                                        <dt class="font-medium text-gray-500">Tanggal</dt>
                                        <dd class="mt-1">{{ $item->tanggal_pelaksanaan ? \Carbon\Carbon::parse($item->tanggal_pelaksanaan)->translatedFormat('d F Y') : '-' }}</dd>
                                    </div>
                                    <div>
                                        <dt class="font-medium text-gray-500">Lampiran</dt>
                                        <dd class="mt-1">
                                            @if(!empty($item->lampiran_berita_acara))
                                                <a href="{{ Storage::url($item->lampiran_berita_acara) }}" target="_blank" class="text-blue-600 hover:underline">Lihat Dokumen</a>
                                            @else
                                                <span class="text-gray-500">Belum diinput</span>
                                            @endif
                                        </dd>
                                    </div>
                                </dl>
                            @empty
                                <p class="text-sm text-gray-500 mt-2">Data sosialisasi belum diinput.</p>
                            @endforelse

                            <h4 class="text-lg font-semibold text-gray-700 mt-6">B. Inventarisasi & Pengumuman</h4>
                             @forelse($project->inventarisasis as $item)
                                <dl class="grid grid-cols-1 md:grid-cols-4 gap-x-6 gap-y-4 text-sm mt-2 mb-4 p-4 border rounded-md">
                                    <div>
                                        <dt class="font-medium text-gray-500">Kecamatan</dt>
                                        <dd class="mt-1">{{ $item->nama_kecamatan ?? '-' }}</dd>
                                    </div>
                                    <div>
                                        <dt class="font-medium text-gray-500">Status</dt>
                                        <dd class="mt-1">{{ $item->status ?? '-' }}</dd>
                                    </div>
                                    <div>
                                        <dt class="font-medium text-gray-500">Tanggal</dt>
                                        <dd class="mt-1">{{ $item->tanggal_pelaksanaan ? \Carbon\Carbon::parse($item->tanggal_pelaksanaan)->translatedFormat('d F Y') : '-' }}</dd>
                                    </div>
                                    <div>
                                        <dt class="font-medium text-gray-500">Lampiran</dt>
                                        <dd class="mt-1">
                                            @if(!empty($item->lampiran_berita_acara))
                                                <a href="{{ Storage::url($item->lampiran_berita_acara) }}" target="_blank" class="text-blue-600 hover:underline">Lihat Dokumen</a>
                                            @else
                                                <span class="text-gray-500">Belum diinput</span>
                                            @endif
                                        </dd>
                                    </div>
                                </dl>
                            @empty
                                <p class="text-sm text-gray-500 mt-2">Data inventarisasi belum diinput.</p>
                            @endforelse
                            
                            <h4 class="text-lg font-semibold text-gray-700 mt-6">C. Musyawarah (Tahapan)</h4>
                             @forelse($project->musyawarah_subs as $item)
                                <dl class="grid grid-cols-1 md:grid-cols-4 gap-x-6 gap-y-4 text-sm mt-2 mb-4 p-4 border rounded-md">
                                    <div>
                                        <dt class="font-medium text-gray-500">Kecamatan</dt>
                                        <dd class="mt-1">{{ $item->nama_kecamatan ?? '-' }}</dd>
                                    </div>
                                    <div>
                                        <dt class="font-medium text-gray-500">Status</dt>
                                        <dd class="mt-1">{{ $item->status ?? '-' }}</dd>
                                    </div>
                                    <div>
                                        <dt class="font-medium text-gray-500">Tanggal</dt>
                                        <dd class="mt-1">{{ $item->tanggal_pelaksanaan ? \Carbon\Carbon::parse($item->tanggal_pelaksanaan)->translatedFormat('d F Y') : '-' }}</dd>
                                    </div>
                                    <div>
                                        <dt class="font-medium text-gray-500">Lampiran</dt>
                                        <dd class="mt-1">
                                            @if(!empty($item->lampiran_berita_acara))
                                                <a href="{{ Storage::url($item->lampiran_berita_acara) }}" target="_blank" class="text-blue-600 hover:underline">Lihat Dokumen</a>
                                            @else
                                                <span class="text-gray-500">Belum diinput</span>
                                            @endif
                                        </dd>
                                    </div>
                                </dl>
                            @empty
                                <p class="text-sm text-gray-500 mt-2">Data musyawarah (tahapan) belum diinput.</p>
                            @endforelse
                            
                            <h4 class="text-lg font-semibold text-gray-700 mt-6">D. Pembayaran (Tahapan)</h4>
                             @forelse($project->pembayaran_subs as $item)
                                <dl class="grid grid-cols-1 md:grid-cols-4 gap-x-6 gap-y-4 text-sm mt-2 mb-4 p-4 border rounded-md">
                                    <div>
                                        <dt class="font-medium text-gray-500">Kecamatan</dt>
                                        <dd class="mt-1">{{ $item->nama_kecamatan ?? '-' }}</dd>
                                    </div>
                                    <div>
                                        <dt class="font-medium text-gray-500">Status</dt>
                                        <dd class="mt-1">{{ $item->status ?? '-' }}</dd>
                                    </div>
                                    <div>
                                        <dt class="font-medium text-gray-500">Tanggal</dt>
                                        <dd class="mt-1">{{ $item->tanggal_pelaksanaan ? \Carbon\Carbon::parse($item->tanggal_pelaksanaan)->translatedFormat('d F Y') : '-' }}</dd>
                                    </div>
                                    <div>
                                        <dt class="font-medium text-gray-500">Lampiran</dt>
                                        <dd class="mt-1">
                                            @if(!empty($item->lampiran_berita_acara))
                                                <a href="{{ Storage::url($item->lampiran_berita_acara) }}" target="_blank" class="text-blue-600 hover:underline">Lihat Dokumen</a>
                                            @else
                                                <span class="text-gray-500">Belum diinput</span>
                                            @endif
                                        </dd>
                                    </div>
                                </dl>
                            @empty
                                <p class="text-sm text-gray-500 mt-2">Data pembayaran (tahapan) belum diinput.</p>
                            @endforelse
                        </div>
                        
                        {{-- Ganti blok kode ini --}}
                        <div class="pt-6">
                            <h3 class="text-xl font-bold text-gray-800">Musyawarah</h3>
                            <hr class="my-4">
                                @forelse($project->musyawarahs as $item)
                                <dl class="grid grid-cols-1 md:grid-cols-5 gap-x-6 gap-y-4 text-sm mb-4 p-4 border rounded-md">
                                    <div>
                                        <dt class="font-medium text-gray-500">No. TIP</dt>
                                        <dd class="mt-1">{{ $item->no_tip ?? '-' }}</dd>
                                    </div>
                                    <div>
                                        <dt class="font-medium text-gray-500">Nama Pemilik</dt>
                                        <dd class="mt-1">{{ $item->nama_pemilik ?? '-' }}</dd>
                                    </div>
                                    <div>
                                        <dt class="font-medium text-gray-500">Nilai Ganti Rugi</dt>
                                        <dd class="mt-1">Rp {{ number_format($item->nilai, 0, ',', '.') }}</dd>
                                    </div>
                                    <div>
                                        <dt class="font-medium text-gray-500">Status</dt>
                                        <dd class="mt-1">{{ $item->status ?? '-' }}</dd>
                                    </div>
                                    <div>
                                        <dt class="font-medium text-gray-500">Bukti Dokumen</dt>
                                        <dd class="mt-1">
                                            @if(!empty($item->bukti_musyawarah))
                                                <a href="{{ asset('storage/' . $item->bukti_musyawarah) }}" target="_blank" class="text-blue-600 hover:underline">Lihat Dokumen</a>
                                            @else
                                                <span class="text-gray-500">Belum diinput</span>
                                            @endif
                                        </dd>
                                    </div>
                                </dl>
                            @empty
                                <p class="text-sm text-gray-500">Data musyawarah belum diinput.</p>
                            @endforelse
                        </div>

                        <div class="pt-6">
                            <h3 class="text-xl font-bold text-gray-800">Pembayaran</h3>
                            <hr class="my-4">
                            @forelse($project->musyawarahs->where('status_pembayaran', '!=', null) as $item)
                                <dl class="grid grid-cols-1 md:grid-cols-4 gap-x-6 gap-y-4 text-sm mb-4 p-4 border rounded-md">
                                     <div>
                                        <dt class="font-medium text-gray-500">No. TIP</dt>
                                        <dd class="mt-1">{{ $item->no_tip ?? '-' }}</dd>
                                    </div>
                                    <div>
                                        <dt class="font-medium text-gray-500">Status</dt>
                                        <dd class="mt-1 font-semibold {{ $item->status_pembayaran == 'TERBAYAR' ? 'text-green-600' : 'text-yellow-600' }}">{{ $item->status_pembayaran }}</dd>
                                    </div>
                                    <div>
                                        <dt class="font-medium text-gray-500">Tanggal Bayar</dt>
                                        <dd class="mt-1">{{ $item->tanggal_pembayaran ? \Carbon\Carbon::parse($item->tanggal_pembayaran)->translatedFormat('d F Y') : '-' }}</dd>
                                    </div>
                                    <div>
                                        <dt class="font-medium text-gray-500">Bukti Pembayaran</dt>
                                        <dd class="mt-1">
                                            @if(!empty($item->bukti_pembayaran))
                                                <a href="{{ asset('storage/' . $item->bukti_pembayaran) }}" target="_blank" class="text-blue-600 hover:underline">Lihat Bukti</a>
                                            @else
                                                <span class="text-gray-500">Belum diinput</span>
                                            @endif
                                        </dd>
                                    </div>
                                </dl>
                            @empty
                                <p class="text-sm text-gray-500">Data pembayaran belum diinput.</p>
                            @endforelse
                        </div>

                        <div class="pt-6">
                            <h3 class="text-xl font-bold text-gray-800">Dokumen Hasil</h3>
                            <hr class="my-4">
                             @forelse($project->dokumen_hasil as $item)
                                <dl class="grid grid-cols-1 md:grid-cols-4 gap-x-6 gap-y-4 text-sm mb-4 p-4 border rounded-md">
                                     <div>
                                        <dt class="font-medium text-gray-500">Nama Surat</dt>
                                        <dd class="mt-1">{{ $item->no_surat ?? '-' }}</dd>
                                    </div>
                                    <div>
                                        <dt class="font-medium text-gray-500">Total TIP / Luas</dt>
                                        <dd class="mt-1">{{ $item->total_tip_luas ?? '-' }}</dd>
                                    </div>
                                    <div>
                                        <dt class="font-medium text-gray-500">Tanggal Surat</dt>
                                        <dd class="mt-1">{{ $item->tgl_surat ? \Carbon\Carbon::parse($item->tgl_surat)->translatedFormat('d F Y') : '-' }}</dd>
                                    </div>
                                    <div>
                                        <dt class="font-medium text-gray-500">Dokumen</dt>
                                        <dd class="mt-1">
                                            @if(!empty($item->file_path))
                                                <a href="{{ asset('storage/' . $item->file_path) }}" target="_blank" class="text-blue-600 hover:underline">Lihat Dokumen</a>
                                            @else
                                                <span class="text-gray-500">Belum diinput</span>
                                            @endif
                                        </dd>
                                    </div>
                                </dl>
                            @empty
                                <p class="text-sm text-gray-500">Data dokumen hasil belum diinput.</p>
                            @endforelse
                        </div>
                    @endif

                    @if ($type === 'row')
                        <p class="text-center text-gray-500 py-10">Tampilan detail untuk proyek ROW sedang dalam pengembangan.</p>
                    @endif

                </div>
            </div>
        </div>
    </div>
</x-app-layout>