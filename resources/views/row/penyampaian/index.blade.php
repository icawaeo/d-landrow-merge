<x-app-layout>
    @php
        $isReadOnly = !($row->status_persetujuan === 'belum_diajukan' || str_starts_with($row->status_persetujuan, 'ditolak'));
    @endphp

    @push('content-header')
        <x-content-header
            :proyek="$row"
            tahapan="Penyampaian"
        />
    @endpush

    <div class="py-8 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto space-y-6">
        @if (session('success'))
            <x-alert type="success">{{ session('success') }}</x-alert>
        @endif
        @if ($errors->any())
            <x-alert type="danger">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </x-alert>
        @endif

        <div class="bg-white p-4 sm:p-6 rounded-lg shadow-sm">
            <form method="GET" action="{{ route('row.penyampaian.index', $row->id) }}">
                <div class="flex items-center gap-2">
                    <label for="span_select" class="font-medium text-gray-700">Pilih Span:</label>
                    <select id="span_select" name="span" class="border-gray-300 rounded-md shadow-sm text-sm" onchange="this.form.submit()">
                        <option value="">Semua Span</option>
                        @foreach($spans as $span)
                            <option value="{{ $span }}" @selected($spanFilter == $span)>{{ $span }}</option>
                        @endforeach
                    </select>
                </div>
            </form>
        </div>

        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 overflow-x-auto">
                <table class="min-w-full bg-white">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">No Bidang</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nama Pemilik</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nilai Kompensasi</th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Status Persetujuan</th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Dokumen</th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse ($penetapanNilais as $item)
                            <tr>
                                <td class="px-6 py-4 align-top text-left">{{ $item->no_bidang }}</td>
                                <td class="px-6 py-4 align-top text-left">{{ $item->nama_pemilik }}</td>
                                <td class="px-6 py-4 align-top text-left">Rp. {{ number_format($item->nilai_kompensasi, 0, ',', '.') }}</td>

                                @if($item->penyampaian)
                                    <td class="px-6 py-4 align-top text-center">
                                        <div class="view-mode">
                                            @if($item->penyampaian->status_persetujuan == 'Setuju')
                                                <span class="inline-flex items-center px-3 py-1 text-xs font-semibold text-emerald-800 bg-emerald-200 rounded-full">SETUJU</span>
                                            @elseif($item->penyampaian->status_persetujuan == 'Menolak')
                                                <span class="inline-flex items-center px-3 py-1 text-xs font-semibold text-red-800 bg-red-200 rounded-full">MENOLAK</span>
                                            @else
                                                -
                                            @endif
                                        </div>
                                        <div class="edit-mode hidden">
                                            <select name="status_persetujuan" class="w-full border-gray-300 rounded-md shadow-sm text-sm" form="edit-form-{{ $item->id }}">
                                                <option value="Setuju" @selected($item->penyampaian->status_persetujuan == 'Setuju')>Setuju</option>
                                                <option value="Menolak" @selected($item->penyampaian->status_persetujuan == 'Menolak')>Menolak</option>
                                            </select>
                                        </div>
                                    </td>

                                    <td class="px-6 py-4 align-top text-center">
                                        <div class="view-mode">
                                            @if ($item->penyampaian->dokumen_penyampaian)
                                                <a href="{{ Storage::url($item->penyampaian->dokumen_penyampaian) }}" target="_blank" class="inline-block px-3 py-1 text-xs font-semibold text-blue-800 bg-blue-100 rounded-full hover:underline">
                                                    Lihat Dokumen
                                                </a>
                                            @else
                                                <span class="text-gray-400 text-sm">-</span>
                                            @endif
                                        </div>
                                        <div class="edit-mode hidden">
                                            <input type="file" name="dokumen_penyampaian" class="text-xs w-full" form="edit-form-{{ $item->id }}">
                                            <p class="text-xs text-gray-500 mt-1">Kosongkan jika tak diubah.</p>
                                        </div>
                                    </td>

                                    <td class="px-6 py-4 align-top text-center">
                                        @if(!$isReadOnly)
                                            <div class="view-mode flex justify-center gap-3">
                                                <button type="button" class="text-gray-600 hover:text-indigo-700 edit-btn" title="Edit">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 4H6a2 2 0 00-2 2v12a2 2 0 002 2h12a2 2 0 002-2v-5M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                                                </button>
                                                <form action="{{ route('row.penyampaian.destroy', $item->penyampaian->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-gray-600 hover:text-red-700" title="Hapus">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6M9 7h6m2 0a2 2 0 00-2-2H9a2 2 0 00-2 2h10z" /></svg>
                                                    </button>
                                                </form>
                                            </div>

                                            <form id="edit-form-{{ $item->id }}" action="{{ route('row.penyampaian.update', $item->penyampaian->id) }}" method="POST" enctype="multipart/form-data">
                                                @csrf
                                                @method('PUT')
                                                <div class="edit-mode hidden flex justify-center gap-2">
                                                    <button type="submit" class="text-white bg-green-600 hover:bg-green-700 font-medium rounded-lg text-sm px-3 py-1.5">Update</button>
                                                    <button type="button" class="text-white bg-gray-500 hover:bg-gray-600 font-medium rounded-lg text-sm px-3 py-1.5 cancel-btn">Batal</button>
                                                </div>
                                            </form>
                                        @endif
                                    </td>
                                @else
                                @if(!$isReadOnly)
                                    <td class="px-6 py-4 align-top text-center">
                                        <select name="status_persetujuan" class="w-full border-gray-300 rounded-md shadow-sm text-sm" form="create-form-{{ $item->id }}">
                                            <option value="Setuju">Setuju</option>
                                            <option value="Menolak">Menolak</option>
                                        </select>
                                    </td>
                                    <td class="px-6 py-4 align-top text-center">
                                        <input type="file" name="dokumen_penyampaian" class="text-xs w-full" required form="create-form-{{ $item->id }}">
                                    </td>
                                    <td class="px-6 py-4 align-top text-center">
                                        <form id="create-form-{{ $item->id }}" action="{{ route('row.penyampaian.store', ['row' => $row->id, 'penetapanNilai' => $item->id]) }}" method="POST" enctype="multipart/form-data">
                                            @csrf
                                            <button type="submit" class="text-white bg-blue-600 hover:bg-blue-700 font-medium rounded-lg text-sm px-3 py-1.5">Simpan</button>
                                        </form>
                                    </td>
                                @else
                                <td class="px-6 py-4 align-top text-center">-</td>
                                    <td class="px-6 py-4 align-top text-center">-</td>
                                    <td class="px-6 py-4 align-top text-center">-</td>
                                @endif
                            </tr>
                        @empty
                            <tr><td colspan="6" class="text-center px-6 py-4 text-gray-500">Tidak ada data penetapan nilai untuk span ini.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            document.querySelectorAll('.edit-btn').forEach(button => {
                button.addEventListener('click', function () {
                    const row = this.closest('tr');
                    row.querySelectorAll('.view-mode').forEach(el => el.classList.add('hidden'));
                    row.querySelectorAll('.edit-mode').forEach(el => el.classList.remove('hidden'));
                });
            });

            document.querySelectorAll('.cancel-btn').forEach(button => {
                button.addEventListener('click', function () {
                    const row = this.closest('tr');
                    row.querySelectorAll('.view-mode').forEach(el => el.classList.remove('hidden'));
                    row.querySelectorAll('.edit-mode').forEach(el => el.classList.add('hidden'));
                    
                    const formId = button.closest('form').id;
                    const form = document.getElementById(formId);
                    if (form) {
                        form.reset(); 

                    }
                });
            });
        });
    </script>
</x-app-layout>