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

    <div class="py-8 px-6 max-w-7xl mx-auto space-y-6">
        @if (session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-800 p-4 rounded text-sm">
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-white shadow rounded overflow-x-auto">
            <table class="min-w-full text-sm text-gray-800 border border-gray-200 rounded-lg">
                <thead class="bg-gray-100 text-xs uppercase tracking-wider text-gray-700">
                    <tr>
                        <th class="px-4 py-3 border">No</th>
                        <th class="px-4 py-3 border">SPAN</th>
                        <th class="px-4 py-3 border">BIDANG</th>
                        <th class="px-4 py-3 border">PEMILIK</th>
                        <th class="px-4 py-3 border">DESA</th>
                        <th class="px-4 py-3 border">NILAI</th>
                        <th class="px-4 py-3 border">STATUS</th>
                        <th class="px-4 py-3 border">TGL</th>
                        <th class="px-4 py-3 border">BUKTI</th>
                        <th class="px-4 py-3 border">AKSI</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($penyampaians as $i => $penyampaian)
                        @php
                            $nilai = $penyampaian->penetapanNilai;
                            $pembayaran = $penyampaian->pembayaranMenu;
                        @endphp
                        <tr class="hover:bg-gray-50">
                            <td class="border px-4 py-2 text-center">{{ $i + 1 }}</td>
                            <td class="border px-4 py-2">{{ $nilai->span }}</td>
                            <td class="border px-4 py-2">{{ $nilai->no_bidang }}</td>
                            <td class="border px-4 py-2">{{ $nilai->nama_pemilik }}</td>
                            <td class="border px-4 py-2">{{ $nilai->desa }}</td>
                            <td class="border px-4 py-2 text-right">
                                Rp {{ number_format($nilai->nilai_kompensasi, 0, ',', '.') }}
                            </td>
                            <td class="border px-4 py-2 text-center">
                                @if ($pembayaran?->status === 'TERBAYAR')
                                    <span class="inline-flex items-center px-2 py-1 rounded-full bg-green-100 text-green-700 text-xs font-semibold">
                                        ✅ TERBAYAR
                                    </span>
                                @elseif ($pembayaran?->status === 'BELUM TERBAYAR')
                                    <span class="inline-flex items-center px-2 py-1 rounded-full bg-red-100 text-red-700 text-xs font-semibold">
                                        ❌ BELUM
                                    </span>
                                @else
                                    <span class="text-gray-400 text-xs italic">Belum Diisi</span>
                                @endif
                            </td>
                            <td class="border px-4 py-2 text-center">
                                {{ $pembayaran?->tanggal_pembayaran ?? '-' }}
                            </td>
                            <td class="border px-4 py-2 text-center">
                                @if ($pembayaran && $pembayaran->bukti_dokumen)
                                    <a href="{{ asset('storage/' . $pembayaran->bukti_dokumen) }}" target="_blank"
                                        class="text-blue-600 underline text-xs">📄 Lihat</a>
                                @else
                                    <span class="text-gray-400 text-xs">Belum Ada</span>
                                @endif
                            </td>
                            <td class="border px-4 py-2 text-center">
                                @if ($pembayaran)
                                    <a href="#" onclick="event.preventDefault(); document.getElementById('form-{{ $pembayaran->id }}').classList.toggle('hidden')" class="text-green-600 text-xs hover:underline">
                                        ✏ Update
                                    </a>
                                    <form action="{{ route('row.pembayaran-menu.destroy', $pembayaran->id) }}" method="POST" class="inline" onsubmit="return confirm('Hapus data ini?')">
                                        @csrf @method('DELETE')
                                        <button class="text-red-600 text-xs hover:underline">🗑 Hapus</button>
                                    </form>
                                @else
                                    <form action="{{ route('row.pembayaran-menu.store', $penyampaian->id) }}"
                                        method="POST" enctype="multipart/form-data"
                                        class="flex flex-wrap items-center gap-1 justify-center text-xs">
                                        @csrf

                                        <select name="status" required class="border rounded px-1 py-0.5 text-xs w-[90px]">
                                            <option value="TERBAYAR">TERBAYAR</option>
                                            <option value="BELUM TERBAYAR">BELUM</option>
                                        </select>

                                        <input type="date" name="tanggal_pembayaran" required
                                            class="border rounded px-1 py-0.5 text-xs w-[100px]">

                                        <input type="file" name="bukti_dokumen"
                                            accept="application/pdf,image/*"
                                            class="text-xs w-[110px] truncate">

                                        <button type="submit"
                                                class="bg-blue-600 text-white px-2 py-0.5 rounded hover:bg-blue-700 transition text-xs">
                                            💾 Simpan
                                        </button>
                                    </form>
                                @endif
                            </td>
                        </tr>

                        {{-- FORM UPDATE --}}
                        @if ($pembayaran)
                            <tr id="form-{{ $pembayaran->id }}" class="hidden bg-gray-50">
                                <td colspan="10" class="p-3 border">
                                    <form action="{{ route('row.pembayaran-menu.update', $pembayaran->id) }}"
                                        method="POST" enctype="multipart/form-data"
                                        class="flex flex-wrap items-end gap-2 text-xs">
                                        @csrf @method('PUT')

                                        <div class="flex flex-col">
                                            <label class="text-[11px]">Status</label>
                                            <select name="status" required class="border rounded px-1 py-0.5 w-[90px]">
                                                <option value="TERBAYAR" {{ $pembayaran->status == 'TERBAYAR' ? 'selected' : '' }}>TERBAYAR</option>
                                                <option value="BELUM TERBAYAR" {{ $pembayaran->status == 'BELUM TERBAYAR' ? 'selected' : '' }}>BELUM</option>
                                            </select>
                                        </div>

                                        <div class="flex flex-col">
                                            <label class="text-[11px]">Tanggal</label>
                                            <input type="date" name="tanggal_pembayaran"
                                                value="{{ $pembayaran->tanggal_pembayaran }}"
                                                class="border rounded px-1 py-0.5 w-[100px]">
                                        </div>

                                        <div class="flex flex-col">
                                            <label class="text-[11px]">Bukti</label>
                                            <input type="file" name="bukti_dokumen"
                                                accept="application/pdf,image/*"
                                                class="text-xs w-[120px] truncate">
                                        </div>

                                        <div class="flex items-end">
                                            <button type="submit"
                                                    class="bg-green-600 text-white px-2 py-0.5 rounded hover:bg-green-700 transition">
                                                💾 Simpan
                                            </button>
                                        </div>
                                    </form>
                                </td>
                            </tr>
                        @endif
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="bg-blue-50 border-l-4 border-blue-400 p-4 text-sm text-blue-800 rounded">
            Hanya data dengan status <strong>SETUJU</strong> yang ditampilkan. Silakan isi status <b>Terbayar</b>, <b>Tanggal</b>, dan <b>Upload Bukti Dokumen</b> jika pembayaran telah dilakukan.
        </div>
    </div>
</x-app-layout>
