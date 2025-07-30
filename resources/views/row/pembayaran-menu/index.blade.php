<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4">
            <a href="{{ url()->previous() }}" class="text-gray-500 hover:text-gray-700">
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
            </a>
            <h2 class="text-xl font-semibold text-gray-800 leading-tight">Pembayaran</h2>
        </div>
    </x-slot>

    <div class="py-8 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto space-y-6">
        
        {{-- Menggunakan Blade Component untuk notifikasi yang konsisten --}}
        @if (session('success'))
            <x-alert type="success">{{ session('success') }}</x-alert>
        @endif

        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 overflow-x-auto">
                <table class="min-w-full bg-white">
                    <thead class="bg-gray-50">
                        <tr>
                            {{-- PERBAIKAN: Menyesuaikan gaya header tabel --}}
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Span</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Bidang</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pemilik</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Desa</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nilai</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tgl Bayar</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Bukti</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach ($penyampaians as $i => $penyampaian)
                            @php
                                $nilai = $penyampaian->penetapanNilai;
                                $pembayaran = $penyampaian->pembayaranMenu;
                            @endphp
                            <tr class="hover:bg-gray-50">
                                {{-- PERBAIKAN: Menyesuaikan gaya sel tabel --}}
                                <td class="px-6 py-4 whitespace-nowrap">{{ $i + 1 }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $nilai->span }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $nilai->no_bidang }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $nilai->nama_pemilik }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $nilai->desa }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-right">
                                    Rp {{ number_format($nilai->nilai_kompensasi, 0, ',', '.') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    @if ($pembayaran?->status === 'TERBAYAR')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full bg-green-100 text-green-800 text-xs font-medium">
                                            TERBAYAR
                                        </span>
                                    @elseif ($pembayaran?->status === 'BELUM TERBAYAR')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full bg-red-100 text-red-800 text-xs font-medium">
                                            BELUM
                                        </span>
                                    @else
                                        <span class="text-gray-400 text-xs italic">Belum Diisi</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    {{ $pembayaran?->tanggal_pembayaran ? \Carbon\Carbon::parse($pembayaran->tanggal_pembayaran)->format('d/m/Y') : '-' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    @if ($pembayaran && $pembayaran->bukti_dokumen)
                                        <a href="{{ asset('storage/' . $pembayaran->bukti_dokumen) }}" target="_blank"
                                           class="text-blue-600 hover:underline text-sm">Lihat</a>
                                    @else
                                        <span class="text-gray-400 text-xs">Kosong</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <div class="flex items-center space-x-4">
                                        @if ($pembayaran)
                                            {{-- PERBAIKAN: Mengganti tombol dengan ikon --}}
                                            <a href="#" onclick="event.preventDefault(); document.getElementById('form-{{ $pembayaran->id }}').classList.toggle('hidden')" class="text-indigo-600 hover:text-indigo-900" title="Update">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                    <path d="M17.414 2.586a2 2 0 00-2.828 0L7 10.172V13h2.828l7.586-7.586a2 2 0 000-2.828z" />
                                                    <path fill-rule="evenodd" d="M2 6a2 2 0 012-2h4a1 1 0 010 2H4v10h10v-4a1 1 0 112 0v4a2 2 0 01-2 2H4a2 2 0 01-2-2V6z" clip-rule="evenodd" />
                                                </svg>
                                            </a>
                                            <form action="{{ route('row.pembayaran-menu.destroy', $pembayaran->id) }}" method="POST" class="inline" onsubmit="return confirm('Hapus data ini?')">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900" title="Hapus">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                        <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                                                    </svg>
                                                </button>
                                            </form>
                                        @else
                                            <a href="#" onclick="event.preventDefault(); document.getElementById('form-create-{{ $penyampaian->id }}').classList.toggle('hidden')" class="text-blue-600 hover:text-blue-900" title="Input Data">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v2H7a1 1 0 100 2h2v2a1 1 0 102 0v-2h2a1 1 0 100-2h-2V7z" clip-rule="evenodd" />
                                                </svg>
                                            </a>
                                        @endif
                                    </div>
                                </td>
                            </tr>

                            {{-- FORM UPDATE (TERSEMBUNYI) --}}
                            @if ($pembayaran)
                                <tr id="form-{{ $pembayaran->id }}" class="hidden">
                                    <td colspan="10" class="p-4 bg-gray-50">
                                        <form action="{{ route('row.pembayaran-menu.update', $pembayaran->id) }}" method="POST" enctype="multipart/form-data" class="flex items-end gap-4">
                                            @csrf @method('PUT')
                                            <div>
                                                <label class="block text-xs font-medium text-gray-700">Status</label>
                                                <select name="status" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm text-sm">
                                                    <option value="TERBAYAR" @selected($pembayaran->status == 'TERBAYAR')>TERBAYAR</option>
                                                    <option value="BELUM TERBAYAR" @selected($pembayaran->status == 'BELUM TERBAYAR')>BELUM TERBAYAR</option>
                                                </select>
                                            </div>
                                            <div>
                                                <label class="block text-xs font-medium text-gray-700">Tanggal</label>
                                                <input type="date" name="tanggal_pembayaran" value="{{ $pembayaran->tanggal_pembayaran }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm text-sm">
                                            </div>
                                            <div>
                                                <label class="block text-xs font-medium text-gray-700">Ganti Bukti</label>
                                                <input type="file" name="bukti_dokumen" class="mt-1 block w-full text-xs text-gray-500">
                                            </div>
                                            <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700 text-sm">Simpan</button>
                                        </form>
                                    </td>
                                </tr>
                            @else
                                {{-- FORM CREATE (TERSEMBUNYI) --}}
                                <tr id="form-create-{{ $penyampaian->id }}" class="hidden">
                                     <td colspan="10" class="p-4 bg-gray-50">
                                        <form action="{{ route('row.pembayaran-menu.store', $penyampaian->id) }}" method="POST" enctype="multipart/form-data" class="flex items-end gap-4">
                                            @csrf
                                            <div>
                                                <label class="block text-xs font-medium text-gray-700">Status</label>
                                                <select name="status" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm text-sm">
                                                    <option value="TERBAYAR">TERBAYAR</option>
                                                    <option value="BELUM TERBAYAR">BELUM TERBAYAR</option>
                                                </select>
                                            </div>
                                            <div>
                                                <label class="block text-xs font-medium text-gray-700">Tanggal</label>
                                                <input type="date" name="tanggal_pembayaran" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm text-sm">
                                            </div>
                                            <div>
                                                <label class="block text-xs font-medium text-gray-700">Upload Bukti</label>
                                                <input type="file" name="bukti_dokumen" required class="mt-1 block w-full text-xs text-gray-500">
                                            </div>
                                            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 text-sm">Simpan</button>
                                        </form>
                                    </td>
                                </tr>
                            @endif
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="bg-blue-50 border-l-4 border-blue-400 p-4 text-sm text-blue-800 rounded">
            Hanya data dengan status <strong>SETUJU</strong> dari halaman Penyampaian yang ditampilkan. Silakan isi status <b>Terbayar</b>, <b>Tanggal</b>, dan <b>Upload Bukti Dokumen</b> jika pembayaran telah dilakukan.
        </div>
    </div>
</x-app-layout>
