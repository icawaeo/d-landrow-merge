<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4">
            <a href="{{ url()->previous() }}" class="text-gray-500 hover:text-gray-700">
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7 7-7m-7 7h18" />
                </svg>
            </a>
            <h2 class="text-xl font-semibold text-gray-800 leading-tight">Penyampaian</h2>
        </div>
    </x-slot>

    <div class="py-8 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto space-y-6">
        @if (session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-800 p-4 rounded text-sm">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="bg-red-100 border-l-4 border-red-500 text-red-800 p-4 rounded text-sm">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Tabel Data -->
        <div class="bg-white p-6 rounded shadow overflow-x-auto">
            <table class="min-w-full text-sm text-gray-700 border border-gray-200 table-auto">
                <thead class="bg-gray-100 text-gray-800 font-semibold">
                    <tr class="text-left">
                        <th class="border px-4 py-2 w-8">No</th>
                        <th class="border px-4 py-2 w-24">SPAN</th>
                        <th class="border px-4 py-2 w-28">NO BIDANG</th>
                        <th class="border px-4 py-2 w-40">PEMILIK</th>
                        <th class="border px-4 py-2 w-40">DESA</th>
                        <th class="border px-4 py-2 w-40">NILAI</th>
                        <th class="border px-4 py-2 w-28">STATUS</th>
                        <th class="border px-4 py-2 w-52">UPLOAD</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($penetapanNilais as $item)
                        <tr class="hover:bg-gray-50">
                            <td class="border px-4 py-2">{{ $loop->iteration }}</td>
                            <td class="border px-4 py-2">{{ $item->span }}</td>
                            <td class="border px-4 py-2">{{ $item->no_bidang }}</td>
                            <td class="border px-4 py-2">{{ $item->nama_pemilik }}</td>
                            <td class="border px-4 py-2">{{ $item->desa }}</td>
                            <td class="border px-4 py-2">Rp {{ number_format($item->nilai_kompensasi, 0, ',', '.') }}</td>
                            <td class="border px-4 py-2">
                                @php
                                    $status = $item->penyampaian?->status_persetujuan;
                                @endphp
                                @if ($status === 'Setuju')
                                    <span class="inline-flex items-center gap-1 bg-green-100 text-green-800 text-xs px-2 py-1 rounded font-medium">
                                        <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" stroke-width="2"
                                            viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                        Setuju
                                    </span>
                                @elseif ($status === 'Tidak Setuju')
                                    <span class="inline-flex items-center gap-1 bg-red-100 text-red-800 text-xs px-2 py-1 rounded font-medium">
                                        <svg class="w-4 h-4 text-red-600" fill="none" stroke="currentColor" stroke-width="2"
                                            viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"></path>
                                        </svg>
                                        Tidak Setuju
                                    </span>
                                @else
                                    <span class="text-gray-400 text-xs">-</span>
                                @endif
                            </td>
                            <td class="border px-4 py-2">
                                @if ($item->penyampaian && $item->penyampaian->bukti_dokumen)
                                    <div class="space-y-1">
                                        <a href="{{ asset('storage/' . $item->penyampaian->bukti_dokumen) }}" target="_blank" class="text-blue-600 hover:underline text-xs">📄 Lihat Dokumen</a>
                                        <div class="flex gap-2 mt-1">
                                            <!-- Edit button -->
                                            <button onclick="toggleEdit('{{ $item->penyampaian->id }}')" class="text-blue-600 text-xs hover:underline">📤 Update</button>
                                            <!-- Hapus Dokumen button -->
                                            <form action="{{ route('row.penyampaian.file.delete', $item->penyampaian->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus dokumen ini saja?')" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-500 text-xs hover:underline">❌ Hapus Dokumen</button>
                                            </form>
                                        </div>
                                    </div>
                                    <tr id="edit-form-{{ $item->penyampaian->id }}" class="hidden bg-gray-50">
                                        <td colspan="9" class="border px-4 py-2">
                                            <form action="{{ route('row.penyampaian.update', $item->penyampaian->id) }}" method="POST" enctype="multipart/form-data" class="space-y-2 text-sm">
                                                @csrf
                                                @method('PUT')
                                                <div class="grid grid-cols-1 md:grid-cols-3 gap-3 items-center">
                                                    <!-- Status -->
                                                    <div>
                                                        <label class="block text-gray-700 text-xs mb-1" for="status_persetujuan">Status</label>
                                                        <select name="status_persetujuan" required class="w-full max-w-[140px] border rounded px-2 py-1 text-sm focus:ring-2 focus:ring-blue-500">
                                                            <option value="Setuju" {{ $item->penyampaian->status_persetujuan == 'Setuju' ? 'selected' : '' }}>Setuju</option>
                                                            <option value="Tidak Setuju" {{ $item->penyampaian->status_persetujuan == 'Tidak Setuju' ? 'selected' : '' }}>Tidak Setuju</option>
                                                        </select>
                                                    </div>

                                                    <!-- Upload Baru -->
                                                    <div>
                                                        <label class="block text-gray-700 text-xs mb-1" for="bukti_dokumen">Unggah Ulang (opsional)</label>
                                                        <input type="file" name="bukti_dokumen" accept="application/pdf,image/*" class="w-full border rounded px-2 py-1 text-sm text-gray-700 file:bg-blue-100 file:border-0 file:px-3 file:py-1 file:rounded file:text-blue-800" />
                                                    </div>
                                                </div>

                                                <div class="mt-3">
                                                    <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-4 py-1.5 text-sm rounded shadow-sm">💾 Update</button>
                                                </div>
                                            </form>
                                        </td>
                                    </tr>
                                @else
                                    <!-- Tombol toggle form -->
                                    <button onclick="toggleForm('{{ $item->id }}')" class="text-blue-600 hover:underline text-xs">📝 Unggah</button>
                                @endif
                            </td>
                        </tr>

                        @if (!$item->penyampaian || !$item->penyampaian->bukti_dokumen)
                            <tr id="form-row-{{ $item->id }}" class="hidden bg-gray-50">
                                <td colspan="9" class="border px-4 py-2">
                                <form action="{{ route('row.penyampaian.store', $item->id) }}" method="POST" enctype="multipart/form-data" class="space-y-2 text-sm">
                                    @csrf
                                    <div class="grid grid-cols-1 md:grid-cols-3 gap-3 items-center">
                                        {{-- Pilih Status --}}
                                        <div>
                                            <label class="block text-gray-700 text-xs mb-1" for="status">Status</label>
                                            <select name="status" required class="w-full max-w-[140px] border rounded px-2 py-1 text-sm focus:ring-2 focus:ring-blue-500">
                                                <option value="">Pilih</option>
                                                <option value="Setuju" class="text-green-600">Setuju</option>
                                                <option value="Tidak Setuju" class="text-red-600">Tidak Setuju</option>
                                            </select>
                                        </div>

                                        {{-- Upload File --}}
                                        <div>
                                            <label class="block text-gray-700 text-xs mb-1" for="bukti_dokumen">Unggah Bukti</label>
                                            <input type="file" name="bukti_dokumen" accept="application/pdf,image/*" class="w-full border rounded px-2 py-1 text-sm text-gray-700 file:bg-blue-100 file:border-0 file:px-3 file:py-1 file:rounded file:text-blue-800" required />
                                        </div>
                                    </div>

                                    <div class="mt-3">
                                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-1.5 text-sm rounded shadow-sm transition duration-200">💾 Simpan</button>
                                    </div>
                                </form>
                                </td>
                            </tr>
                        @endif
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Info Box -->
        <div class="bg-yellow-100 border-l-4 border-yellow-400 text-yellow-800 p-4 rounded text-sm">
            <p>Form penyampaian digunakan untuk mengunggah bukti dan status hasil penetapan nilai.</p>
        </div>
    </div>

    <script>
        function toggleForm(id) {
            const formRow = document.getElementById(`form-row-${id}`);
            if (formRow) formRow.classList.toggle('hidden');
        }

        function toggleEdit(id) {
            const formRow = document.getElementById(`edit-form-${id}`);
            if (formRow) formRow.classList.toggle('hidden');
        }
    </script>
</x-app-layout>
