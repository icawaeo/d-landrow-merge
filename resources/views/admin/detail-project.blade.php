<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Detail Proyek: ') }} {{ $project->nama_proyek }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 md:p-8 text-gray-900">

                    <div class="space-y-8">
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
                    </div>

                    <div x-data="{ openSection: 'perizinan' }" class="space-y-4 pt-8">

                        @if ($type === 'pengadaan-tanah')
                            
                            <div class="border rounded-lg">
                                <button @click="openSection = (openSection === 'perizinan' ? '' : 'perizinan')" class="w-full flex justify-between items-center p-4 bg-gray-50 hover:bg-gray-100 focus:outline-none">
                                    <h3 class="text-lg font-bold text-gray-800">Perizinan</h3>
                                    <svg class="w-5 h-5 transform transition-transform" :class="{ 'rotate-180': openSection === 'perizinan' }" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                                </button>
                                <div x-show="openSection === 'perizinan'" x-transition class="p-4 border-t">
                                    @if($project->perizinan)
                                        @php
                                            $perizinan = $project->perizinan;
                                            $izinList = [['name' => 'izin_lingkungan', 'label' => 'Izin Lingkungan'],['name' => 'ikkpr', 'label' => 'IKKPR'],['name' => 'izin_prinsip', 'label' => 'Izin Prinsip'],['name' => 'izin_penetapan_lokasi', 'label' => 'Izin Penetapan Lokasi']];
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
                            </div>

                            <div class="border rounded-lg">
                                <button @click="openSection = (openSection === 'tahapan' ? '' : 'tahapan')" class="w-full flex justify-between items-center p-4 bg-gray-50 hover:bg-gray-100 focus:outline-none">
                                    <h3 class="text-lg font-bold text-gray-800">Tahapan</h3>
                                    <svg class="w-5 h-5 transform transition-transform" :class="{ 'rotate-180': openSection === 'tahapan' }" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                                </button>
                                <div x-show="openSection === 'tahapan'" x-transition class="p-4 border-t space-y-6">
                                    <h4 class="text-lg font-semibold text-gray-700">A. Sosialisasi</h4>
                                    @forelse($project->sosialisasis as $item)
                                        <dl class="grid grid-cols-1 md:grid-cols-4 gap-x-6 gap-y-4 text-sm mt-2 mb-4 p-4 border rounded-md">
                                            <div><dt class="font-medium text-gray-500">Kecamatan</dt><dd class="mt-1">{{ $item->nama_kecamatan ?? '-' }}</dd></div>
                                            <div><dt class="font-medium text-gray-500">Status</dt><dd class="mt-1">{{ $item->status ?? '-' }}</dd></div>
                                            <div><dt class="font-medium text-gray-500">Tanggal</dt><dd class="mt-1">{{ $item->tanggal_pelaksanaan ? \Carbon\Carbon::parse($item->tanggal_pelaksanaan)->translatedFormat('d F Y') : '-' }}</dd></div>
                                            <div><dt class="font-medium text-gray-500">Lampiran</dt><dd class="mt-1">@if(!empty($item->lampiran_berita_acara))<a href="{{ Storage::url($item->lampiran_berita_acara) }}" target="_blank" class="text-blue-600 hover:underline">Lihat Dokumen</a>@else<span class="text-gray-500">Belum diinput</span>@endif</dd></div>
                                        </dl>
                                    @empty
                                        <p class="text-sm text-gray-500 mt-2">Data sosialisasi belum diinput.</p>
                                    @endforelse

                                    <h4 class="text-lg font-semibold text-gray-700 mt-6">B. Inventarisasi & Pengumuman</h4>
                                    @forelse($project->inventarisasis as $item)
                                        <dl class="grid grid-cols-1 md:grid-cols-4 gap-x-6 gap-y-4 text-sm mt-2 mb-4 p-4 border rounded-md">
                                            <div><dt class="font-medium text-gray-500">Kecamatan</dt><dd class="mt-1">{{ $item->nama_kecamatan ?? '-' }}</dd></div>
                                            <div><dt class="font-medium text-gray-500">Status</dt><dd class="mt-1">{{ $item->status ?? '-' }}</dd></div>
                                            <div><dt class="font-medium text-gray-500">Tanggal</dt><dd class="mt-1">{{ $item->tanggal_pelaksanaan ? \Carbon\Carbon::parse($item->tanggal_pelaksanaan)->translatedFormat('d F Y') : '-' }}</dd></div>
                                            <div><dt class="font-medium text-gray-500">Lampiran</dt><dd class="mt-1">@if(!empty($item->lampiran_berita_acara))<a href="{{ Storage::url($item->lampiran_berita_acara) }}" target="_blank" class="text-blue-600 hover:underline">Lihat Dokumen</a>@else<span class="text-gray-500">Belum diinput</span>@endif</dd></div>
                                        </dl>
                                    @empty
                                        <p class="text-sm text-gray-500 mt-2">Data inventarisasi belum diinput.</p>
                                    @endforelse

                                    <h4 class="text-lg font-semibold text-gray-700 mt-6">C. Musyawarah (Tahapan)</h4>
                                    @forelse($project->musyawarah_subs as $item)
                                        <dl class="grid grid-cols-1 md:grid-cols-4 gap-x-6 gap-y-4 text-sm mt-2 mb-4 p-4 border rounded-md">
                                            <div><dt class="font-medium text-gray-500">Kecamatan</dt><dd class="mt-1">{{ $item->nama_kecamatan ?? '-' }}</dd></div>
                                            <div><dt class="font-medium text-gray-500">Status</dt><dd class="mt-1">{{ $item->status ?? '-' }}</dd></div>
                                            <div><dt class="font-medium text-gray-500">Tanggal</dt><dd class="mt-1">{{ $item->tanggal_pelaksanaan ? \Carbon\Carbon::parse($item->tanggal_pelaksanaan)->translatedFormat('d F Y') : '-' }}</dd></div>
                                            <div><dt class="font-medium text-gray-500">Lampiran</dt><dd class="mt-1">@if(!empty($item->lampiran_berita_acara))<a href="{{ Storage::url($item->lampiran_berita_acara) }}" target="_blank" class="text-blue-600 hover:underline">Lihat Dokumen</a>@else<span class="text-gray-500">Belum diinput</span>@endif</dd></div>
                                        </dl>
                                    @empty
                                        <p class="text-sm text-gray-500 mt-2">Data musyawarah (tahapan) belum diinput.</p>
                                    @endforelse
                                    
                                    <h4 class="text-lg font-semibold text-gray-700 mt-6">D. Pembayaran (Tahapan)</h4>
                                    @forelse($project->pembayaran_subs as $item)
                                        <dl class="grid grid-cols-1 md:grid-cols-4 gap-x-6 gap-y-4 text-sm mt-2 mb-4 p-4 border rounded-md">
                                            <div><dt class="font-medium text-gray-500">Kecamatan</dt><dd class="mt-1">{{ $item->nama_kecamatan ?? '-' }}</dd></div>
                                            <div><dt class="font-medium text-gray-500">Status</dt><dd class="mt-1">{{ $item->status ?? '-' }}</dd></div>
                                            <div><dt class="font-medium text-gray-500">Tanggal</dt><dd class="mt-1">{{ $item->tanggal_pelaksanaan ? \Carbon\Carbon::parse($item->tanggal_pelaksanaan)->translatedFormat('d F Y') : '-' }}</dd></div>
                                            <div><dt class="font-medium text-gray-500">Lampiran</dt><dd class="mt-1">@if(!empty($item->lampiran_berita_acara))<a href="{{ Storage::url($item->lampiran_berita_acara) }}" target="_blank" class="text-blue-600 hover:underline">Lihat Dokumen</a>@else<span class="text-gray-500">Belum diinput</span>@endif</dd></div>
                                        </dl>
                                    @empty
                                        <p class="text-sm text-gray-500 mt-2">Data pembayaran (tahapan) belum diinput.</p>
                                    @endforelse
                                </div>
                            </div>
                            
                            <div class="border rounded-lg">
                                <button @click="openSection = (openSection === 'musyawarah' ? '' : 'musyawarah')" class="w-full flex justify-between items-center p-4 bg-gray-50 hover:bg-gray-100 focus:outline-none">
                                    <h3 class="text-lg font-bold text-gray-800">Musyawarah</h3>
                                    <svg class="w-5 h-5 transform transition-transform" :class="{ 'rotate-180': openSection === 'musyawarah' }" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                                </button>
                                <div x-show="openSection === 'musyawarah'" x-transition class="p-4 border-t space-y-4">
                                     @forelse($project->musyawarahs as $item)
                                        <dl class="grid grid-cols-1 md:grid-cols-5 gap-x-6 gap-y-4 text-sm p-4 border rounded-md">
                                            <div><dt class="font-medium text-gray-500">No. TIP</dt><dd class="mt-1">{{ $item->no_tip ?? '-' }}</dd></div>
                                            <div><dt class="font-medium text-gray-500">Nama Pemilik</dt><dd class="mt-1">{{ $item->nama_pemilik ?? '-' }}</dd></div>
                                            <div><dt class="font-medium text-gray-500">Nilai Ganti Rugi</dt><dd class="mt-1">Rp {{ number_format($item->nilai, 0, ',', '.') }}</dd></div>
                                            <div><dt class="font-medium text-gray-500">Status</dt><dd class="mt-1">{{ $item->status ?? '-' }}</dd></div>
                                            <div><dt class="font-medium text-gray-500">Bukti Dokumen</dt><dd class="mt-1">@if(!empty($item->bukti_musyawarah))<a href="{{ asset('storage/' . $item->bukti_musyawarah) }}" target="_blank" class="text-blue-600 hover:underline">Lihat Dokumen</a>@else<span class="text-gray-500">Belum diinput</span>@endif</dd></div>
                                        </dl>
                                    @empty
                                        <p class="text-sm text-gray-500">Data musyawarah belum diinput.</p>
                                    @endforelse
                                </div>
                            </div>

                            <div class="border rounded-lg">
                                <button @click="openSection = (openSection === 'pembayaran' ? '' : 'pembayaran')" class="w-full flex justify-between items-center p-4 bg-gray-50 hover:bg-gray-100 focus:outline-none">
                                    <h3 class="text-lg font-bold text-gray-800">Pembayaran</h3>
                                    <svg class="w-5 h-5 transform transition-transform" :class="{ 'rotate-180': openSection === 'pembayaran' }" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                                </button>
                                <div x-show="openSection === 'pembayaran'" x-transition class="p-4 border-t space-y-4">
                                     @forelse($project->musyawarahs->where('status_pembayaran', '!=', null) as $item)
                                        <dl class="grid grid-cols-1 md:grid-cols-4 gap-x-6 gap-y-4 text-sm p-4 border rounded-md">
                                            <div><dt class="font-medium text-gray-500">No. TIP</dt><dd class="mt-1">{{ $item->no_tip ?? '-' }}</dd></div>
                                            <div><dt class="font-medium text-gray-500">Status</dt><dd class="mt-1 font-semibold {{ $item->status_pembayaran == 'TERBAYAR' ? 'text-green-600' : 'text-yellow-600' }}">{{ $item->status_pembayaran }}</dd></div>
                                            <div><dt class="font-medium text-gray-500">Tanggal Bayar</dt><dd class="mt-1">{{ $item->tanggal_pembayaran ? \Carbon\Carbon::parse($item->tanggal_pembayaran)->translatedFormat('d F Y') : '-' }}</dd></div>
                                            <div><dt class="font-medium text-gray-500">Bukti Pembayaran</dt><dd class="mt-1">@if(!empty($item->bukti_pembayaran))<a href="{{ asset('storage/' . $item->bukti_pembayaran) }}" target="_blank" class="text-blue-600 hover:underline">Lihat Bukti</a>@else<span class="text-gray-500">Belum diinput</span>@endif</dd></div>
                                        </dl>
                                    @empty
                                        <p class="text-sm text-gray-500">Data pembayaran belum diinput.</p>
                                    @endforelse
                                </div>
                            </div>

                            <div class="border rounded-lg">
                                <button @click="openSection = (openSection === 'dokumen_hasil' ? '' : 'dokumen_hasil')" class="w-full flex justify-between items-center p-4 bg-gray-50 hover:bg-gray-100 focus:outline-none">
                                    <h3 class="text-lg font-bold text-gray-800">Dokumen Hasil</h3>
                                    <svg class="w-5 h-5 transform transition-transform" :class="{ 'rotate-180': openSection === 'dokumen_hasil' }" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                                </button>
                                <div x-show="openSection === 'dokumen_hasil'" x-transition class="p-4 border-t space-y-4">
                                    @forelse($project->dokumen_hasil as $item)
                                        <dl class="grid grid-cols-1 md:grid-cols-4 gap-x-6 gap-y-4 text-sm p-4 border rounded-md">
                                            <div><dt class="font-medium text-gray-500">Nama Surat</dt><dd class="mt-1">{{ $item->no_surat ?? '-' }}</dd></div>
                                            <div><dt class="font-medium text-gray-500">Total TIP / Luas</dt><dd class="mt-1">{{ $item->total_tip_luas ?? '-' }}</dd></div>
                                            <div><dt class="font-medium text-gray-500">Tanggal Surat</dt><dd class="mt-1">{{ $item->tgl_surat ? \Carbon\Carbon::parse($item->tgl_surat)->translatedFormat('d F Y') : '-' }}</dd></div>
                                            <div><dt class="font-medium text-gray-500">Dokumen</dt><dd class="mt-1">@if(!empty($item->file_path))<a href="{{ asset('storage/' . $item->file_path) }}" target="_blank" class="text-blue-600 hover:underline">Lihat Dokumen</a>@else<span class="text-gray-500">Belum diinput</span>@endif</dd></div>
                                        </dl>
                                    @empty
                                        <p class="text-sm text-gray-500">Data dokumen hasil belum diinput.</p>
                                    @endforelse
                                </div>
                            </div>
                        @endif

                        @if ($type === 'row')
                            <div class="border rounded-lg">
                                <button @click="openSection = (openSection === 'perizinan' ? '' : 'perizinan')" class="w-full flex justify-between items-center p-4 bg-gray-50 hover:bg-gray-100 focus:outline-none">
                                    <h3 class="text-lg font-bold text-gray-800">Perizinan</h3>
                                    <svg class="w-5 h-5 transform transition-transform" :class="{ 'rotate-180': openSection === 'perizinan' }" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                                </button>
                                <div x-show="openSection === 'perizinan'" x-transition class="p-4 border-t">
                                    @if($project->row_perizinans->first())
                                        @php
                                            $perizinan = $project->row_perizinans->first();
                                            $izinList = [['name' => 'izin_lingkungan', 'label' => 'Izin Lingkungan'], ['name' => 'izin_rt_rw', 'label' => 'Izin RT/RW'], ['name' => 'izin_prinsip', 'label' => 'Izin Prinsip'], ['name' => 'izin_penetapan_lokasi', 'label' => 'Izin Penetapan Lokasi']];
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
                            </div>

                            <div class="border rounded-lg">
                                <button @click="openSection = (openSection === 'tahapan' ? '' : 'tahapan')" class="w-full flex justify-between items-center p-4 bg-gray-50 hover:bg-gray-100 focus:outline-none">
                                    <h3 class="text-lg font-bold text-gray-800">Tahapan</h3>
                                    <svg class="w-5 h-5 transform transition-transform" :class="{ 'rotate-180': openSection === 'tahapan' }" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                                </button>
                                <div x-show="openSection === 'tahapan'" x-transition class="p-4 border-t space-y-6">
                                    <h4 class="text-lg font-semibold text-gray-700">A. Sosialisasi</h4>
                                    @forelse($project->row_sosialisasis as $item)
                                        <dl class="grid grid-cols-1 md:grid-cols-4 gap-x-6 gap-y-4 text-sm mt-2 mb-4 p-4 border rounded-md">
                                            <div><dt class="font-medium text-gray-500">Kecamatan</dt><dd class="mt-1">{{ $item->nama_kecamatan ?? '-' }}</dd></div>
                                            <div><dt class="font-medium text-gray-500">Status</dt><dd class="mt-1">{{ $item->status ?? '-' }}</dd></div>
                                            <div><dt class="font-medium text-gray-500">Tanggal</dt><dd class="mt-1">{{ $item->tanggal_pelaksanaan ? \Carbon\Carbon::parse($item->tanggal_pelaksanaan)->translatedFormat('d F Y') : '-' }}</dd></div>
                                            <div><dt class="font-medium text-gray-500">Lampiran</dt><dd class="mt-1">@if(!empty($item->lampiran_berita_acara))<a href="{{ Storage::url($item->lampiran_berita_acara) }}" target="_blank" class="text-blue-600 hover:underline">Lihat Dokumen</a>@else<span class="text-gray-500">Belum diinput</span>@endif</dd></div>
                                        </dl>
                                    @empty
                                        <p class="text-sm text-gray-500 mt-2">Data sosialisasi belum diinput.</p>
                                    @endforelse

                                    <h4 class="text-lg font-semibold text-gray-700 mt-6">B. Inventarisasi & Pengumuman</h4>
                                    @forelse($project->row_inventarisasis as $item)
                                        <dl class="grid grid-cols-1 md:grid-cols-4 gap-x-6 gap-y-4 text-sm mt-2 mb-4 p-4 border rounded-md">
                                            <div><dt class="font-medium text-gray-500">Kecamatan</dt><dd class="mt-1">{{ $item->nama_kecamatan ?? '-' }}</dd></div>
                                            <div><dt class="font-medium text-gray-500">Status</dt><dd class="mt-1">{{ $item->status ?? '-' }}</dd></div>
                                            <div><dt class="font-medium text-gray-500">Tanggal</dt><dd class="mt-1">{{ $item->tanggal_pelaksanaan ? \Carbon\Carbon::parse($item->tanggal_pelaksanaan)->translatedFormat('d F Y') : '-' }}</dd></div>
                                            <div><dt class="font-medium text-gray-500">Lampiran</dt><dd class="mt-1">@if(!empty($item->lampiran_berita_acara))<a href="{{ Storage::url($item->lampiran_berita_acara) }}" target="_blank" class="text-blue-600 hover:underline">Lihat Dokumen</a>@else<span class="text-gray-500">Belum diinput</span>@endif</dd></div>
                                        </dl>
                                    @empty
                                        <p class="text-sm text-gray-500 mt-2">Data inventarisasi belum diinput.</p>
                                    @endforelse
                                    
                                    <h4 class="text-lg font-semibold text-gray-700 mt-6">C. Musyawarah</h4>
                                    @forelse($project->row_musyawarah_subs as $item)
                                        <dl class="grid grid-cols-1 md:grid-cols-4 gap-x-6 gap-y-4 text-sm mt-2 mb-4 p-4 border rounded-md">
                                            <div><dt class="font-medium text-gray-500">Kecamatan</dt><dd class="mt-1">{{ $item->nama_kecamatan ?? '-' }}</dd></div>
                                            <div><dt class="font-medium text-gray-500">Status</dt><dd class="mt-1">{{ $item->status ?? '-' }}</dd></div>
                                            <div><dt class="font-medium text-gray-500">Tanggal</dt><dd class="mt-1">{{ $item->tanggal_pelaksanaan ? \Carbon\Carbon::parse($item->tanggal_pelaksanaan)->translatedFormat('d F Y') : '-' }}</dd></div>
                                            <div><dt class="font-medium text-gray-500">Lampiran</dt><dd class="mt-1">@if(!empty($item->lampiran_berita_acara))<a href="{{ Storage::url($item->lampiran_berita_acara) }}" target="_blank" class="text-blue-600 hover:underline">Lihat Dokumen</a>@else<span class="text-gray-500">Belum diinput</span>@endif</dd></div>
                                        </dl>
                                    @empty
                                        <p class="text-sm text-gray-500 mt-2">Data musyawarah (tahapan) belum diinput.</p>
                                    @endforelse
                                    
                                    <h4 class="text-lg font-semibold text-gray-700 mt-6">D. Pembayaran</h4>
                                    @forelse($project->row_pembayarans as $item)
                                        <dl class="grid grid-cols-1 md:grid-cols-4 gap-x-6 gap-y-4 text-sm mt-2 mb-4 p-4 border rounded-md">
                                            <div><dt class="font-medium text-gray-500">Kecamatan</dt><dd class="mt-1">{{ $item->nama_kecamatan ?? '-' }}</dd></div>
                                            <div><dt class="font-medium text-gray-500">Status</dt><dd class="mt-1">{{ $item->status ?? '-' }}</dd></div>
                                            <div><dt class="font-medium text-gray-500">Tanggal</dt><dd class="mt-1">{{ $item->tanggal_pelaksanaan ? \Carbon\Carbon::parse($item->tanggal_pelaksanaan)->translatedFormat('d F Y') : '-' }}</dd></div>
                                            <div><dt class="font-medium text-gray-500">Lampiran</dt><dd class="mt-1">@if(!empty($item->lampiran_berita_acara))<a href="{{ Storage::url($item->lampiran_berita_acara) }}" target="_blank" class="text-blue-600 hover:underline">Lihat Dokumen</a>@else<span class="text-gray-500">Belum diinput</span>@endif</dd></div>
                                        </dl>
                                    @empty
                                        <p class="text-sm text-gray-500 mt-2">Data pembayaran (tahapan) belum diinput.</p>
                                    @endforelse
                                </div>
                            </div>
                            
                            <div class="border rounded-lg">
                                <button @click="openSection = (openSection === 'penetapan_nilai' ? '' : 'penetapan_nilai')" class="w-full flex justify-between items-center p-4 bg-gray-50 hover:bg-gray-100 focus:outline-none">
                                    <h3 class="text-lg font-bold text-gray-800">Penetapan Nilai</h3>
                                    <svg class="w-5 h-5 transform transition-transform" :class="{ 'rotate-180': openSection === 'penetapan_nilai' }" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                                </button>
                                <div x-show="openSection === 'penetapan_nilai'" x-transition class="p-4 border-t space-y-4">
                                     @forelse($project->penetapan_nilais as $item)
                                        <dl class="grid grid-cols-1 md:grid-cols-5 gap-x-6 gap-y-4 text-sm p-4 border rounded-md">
                                            <div><dt class="font-medium text-gray-500">Span</dt><dd class="mt-1">{{ $item->span ?? '-' }}</dd></div>
                                            <div><dt class="font-medium text-gray-500">No. Bidang</dt><dd class="mt-1">{{ $item->no_bidang ?? '-' }}</dd></div>
                                            <div><dt class="font-medium text-gray-500">Nama Pemilik</dt><dd class="mt-1">{{ $item->nama_pemilik ?? '-' }}</dd></div>
                                            <div><dt class="font-medium text-gray-500">Desa</dt><dd class="mt-1">{{ $item->desa ?? '-' }}</dd></div>
                                            <div><dt class="font-medium text-gray-500">Nilai Kompensasi</dt><dd class="mt-1">Rp {{ number_format($item->nilai_kompensasi, 0, ',', '.') }}</dd></div>
                                        </dl>
                                    @empty
                                        <p class="text-sm text-gray-500">Data penetapan nilai belum diinput.</p>
                                    @endforelse
                                </div>
                            </div>

                            <div class="border rounded-lg">
                                <button @click="openSection = (openSection === 'penyampaian' ? '' : 'penyampaian')" class="w-full flex justify-between items-center p-4 bg-gray-50 hover:bg-gray-100 focus:outline-none">
                                    <h3 class="text-lg font-bold text-gray-800">Penyampaian</h3>
                                    <svg class="w-5 h-5 transform transition-transform" :class="{ 'rotate-180': openSection === 'penyampaian' }" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                                </button>
                                <div x-show="openSection === 'penyampaian'" x-transition class="p-4 border-t space-y-4">
                                     @forelse($project->penyampaians as $item)
                                        <dl class="grid grid-cols-1 md:grid-cols-4 gap-x-6 gap-y-4 text-sm p-4 border rounded-md">
                                            <div><dt class="font-medium text-gray-500">No. Bidang</dt><dd class="mt-1">{{ $item->penetapanNilai->no_bidang ?? '-' }}</dd></div>
                                            <div><dt class="font-medium text-gray-500">Nama Pemilik</dt><dd class="mt-1">{{ $item->penetapanNilai->nama_pemilik ?? '-' }}</dd></div>
                                            <div><dt class="font-medium text-gray-500">Nilai Kompensasi</dt><dd class="mt-1">Rp {{ number_format($item->penetapanNilai->nilai_kompensasi, 0, ',', '.') }}</dd></div>
                                            <div><dt class="font-medium text-gray-500">Status Persetujuan</dt><dd class="mt-1">@if($item->status_persetujuan == 'Setuju')<span class="font-semibold text-green-600">SETUJU</span>@else<span class="font-semibold text-red-600">MENOLAK</span>@endif</dd></div>
                                            <div><dt class="font-medium text-gray-500">Dokumen</dt><dd class="mt-1">@if(!empty($item->dokumen_penyampaian))<a href="{{ asset('storage/' . $item->dokumen_penyampaian) }}" target="_blank" class="text-blue-600 hover:underline">Lihat Dokumen</a>@else<span class="text-gray-500">Belum diinput</span>@endif</dd></div>
                                        </dl>
                                    @empty
                                        <p class="text-sm text-gray-500">Data penyampaian belum diinput.</p>
                                    @endforelse
                                </div>
                            </div>

                            <div class="border rounded-lg">
                                <button @click="openSection = (openSection === 'pembayaran_row' ? '' : 'pembayaran_row')" class="w-full flex justify-between items-center p-4 bg-gray-50 hover:bg-gray-100 focus:outline-none">
                                    <h3 class="text-lg font-bold text-gray-800">Pembayaran</h3>
                                    <svg class="w-5 h-5 transform transition-transform" :class="{ 'rotate-180': openSection === 'pembayaran_row' }" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                                </button>
                                <div x-show="openSection === 'pembayaran_row'" x-transition class="p-4 border-t space-y-4">
                                    @php
                                        $pembayaranDataExists = false;
                                    @endphp
                                    @foreach($project->penyampaians as $penyampaian)
                                        @if($penyampaian->pembayaranMenu)
                                            @php
                                                $pembayaranDataExists = true;
                                                $item = $penyampaian->pembayaranMenu;
                                                $penetapan = $penyampaian->penetapanNilai;
                                            @endphp
                                            <div class="p-4 border rounded-md">
                                                <div class="grid grid-cols-1 md:grid-cols-5 gap-x-6 gap-y-4 text-sm">
                                                    <div>
                                                        <div>
                                                            <p class="font-medium text-gray-500">Span</p>
                                                            <p class="mt-1">{{ $penetapan->span ?? '-' }}</p>
                                                        </div>
                                                        <div class="mt-4">
                                                            <p class="font-medium text-gray-500">Status</p>
                                                            <p class="mt-1 font-semibold {{ $item->status == 'TERBAYAR' ? 'text-green-600' : 'text-red-600' }}">{{ $item->status }}</p>
                                                        </div>
                                                    </div>

                                                    <div>
                                                        <div>
                                                            <p class="font-medium text-gray-500">No. Bidang</p>
                                                            <p class="mt-1">{{ $penetapan->no_bidang ?? '-' }}</p>
                                                        </div>
                                                        <div class="mt-4">
                                                            <p class="font-medium text-gray-500">Tanggal Bayar</p>
                                                            <p class="mt-1">{{ $item->tanggal_pembayaran ? \Carbon\Carbon::parse($item->tanggal_pembayaran)->translatedFormat('d F Y') : '-' }}</p>
                                                        </div>
                                                    </div>

                                                    <div>
                                                        <div>
                                                            <p class="font-medium text-gray-500">Nama Pemilik</p>
                                                            <p class="mt-1">{{ $penetapan->nama_pemilik ?? '-' }}</p>
                                                        </div>
                                                        <div class="mt-4">
                                                            <p class="font-medium text-gray-500">Bukti Dokumen</p>
                                                            <p class="mt-1">
                                                                @if(!empty($item->bukti_dokumen))
                                                                    <a href="{{ asset('storage/' . $item->bukti_dokumen) }}" target="_blank" class="text-blue-600 hover:underline">Lihat Bukti</a>
                                                                @else
                                                                    <span class="text-gray-500">Belum diinput</span>
                                                                @endif
                                                            </p>
                                                        </div>
                                                    </div>

                                                    <div>
                                                        <p class="font-medium text-gray-500">Desa</p>
                                                        <p class="mt-1">{{ $penetapan->desa ?? '-' }}</p>
                                                    </div>

                                                    <div>
                                                        <p class="font-medium text-gray-500">Nilai</p>
                                                        <p class="mt-1">Rp {{ number_format($penetapan->nilai_kompensasi ?? 0, 0, ',', '.') }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    @endforeach

                                    @if(!$pembayaranDataExists)
                                        <p class="text-sm text-gray-500">Data pembayaran belum diinput.</p>
                                    @endif
                                </div>
                            </div>
                        @endif

                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>