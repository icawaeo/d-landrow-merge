<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Persetujuan Admin') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-medium text-gray-900">Proyek yang Membutuhkan Persetujuan Anda</h3>

                    @if (session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mt-4" role="alert">
                            <span class="block sm:inline">{{ session('success') }}</span>
                        </div>
                    @endif

                    <div class="mt-6 overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nama Proyek</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tipe</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse ($projects as $project)
                                    @php
                                        $type = $project instanceof \App\Models\PengadaanTanah ? 'pengadaan-tanah' : 'row';
                                    @endphp
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $project->nama_proyek }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ ucwords(str_replace('-', ' ', $type)) }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <div x-data="{ showTolak: false }" class="flex items-center gap-2">
                                                <form action="{{ route('admin.projects.decide', ['type' => $type, 'id' => $project->id]) }}" method="POST">
                                                    @csrf
                                                    <input type="hidden" name="decision" value="setuju">
                                                    <button type="submit" class="px-4 py-2 bg-green-500 text-white text-xs font-semibold rounded-md hover:bg-green-600">Setuju</button>
                                                </form>

                                                <button @click.prevent="showTolak = true" type="button" class="px-4 py-2 bg-red-500 text-white text-xs font-semibold rounded-md hover:bg-red-600">Tolak</button>

                                                <div x-show="showTolak" x-transition:enter="transition ease-out duration-300" x-transition:leave="transition ease-in duration-200" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50" style="display: none;">
                                                    <div @click.away="showTolak = false" class="bg-white p-6 rounded-lg shadow-xl w-full max-w-md">
                                                        <h4 class="text-lg font-bold mb-4">Catatan Tambahan</h4>
                                                        <form action="{{ route('admin.projects.decide', ['type' => $type, 'id' => $project->id]) }}" method="POST">
                                                            @csrf
                                                            <input type="hidden" name="decision" value="tolak">
                                                            <div>
                                                                <label for="catatan_penolakan_{{$project->id}}" class="block text-sm font-medium text-gray-700">Catatan Penolakan (Wajib diisi)</label>
                                                                <textarea name="catatan_penolakan" id="catatan_penolakan_{{$project->id}}" rows="4" class="mt-1 w-full border-gray-300 rounded-md text-sm" required></textarea>
                                                            </div>
                                                            <div class="mt-4 flex justify-end gap-4">
                                                                <button @click="showTolak = false" type="button" class="px-4 py-2 bg-gray-200 text-gray-800 text-xs font-semibold rounded-md hover:bg-gray-300">Batal</button>
                                                                <button type="submit" class="px-4 py-2 bg-red-600 text-white text-xs font-semibold rounded-md hover:bg-red-700">Konfirmasi Tolak</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="px-6 py-4 text-center text-gray-500">Tidak ada proyek yang memerlukan persetujuan saat ini.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                     <p class="text-sm text-gray-600 mt-4">
                        <strong>Cara Kerja:</strong> Silakan review detail proyek melalui menu di sidebar kiri sebelum memberikan persetujuan. Halaman ini hanya untuk aksi menyetujui atau menolak.
                    </p>

                    <script>
                        function toggleTolakForm(id) {
                            const form = document.getElementById('form-tolak-' + id);
                            form.style.display = form.style.display === 'none' ? 'block' : 'none';
                        }
                    </script>
                </div>
            </div>

            {{-- TABEL BARU UNTUK PROYEK YANG DISETUJUI --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mt-6">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-medium text-gray-900">Proyek yang Telah Anda Setujui</h3>
                    <div class="mt-6 overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nama Proyek</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tipe</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse ($approvedProjects as $project)
                                    @php
                                        $type = $project instanceof \App\Models\PengadaanTanah ? 'pengadaan-tanah' : 'row';
                                    @endphp
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $project->nama_proyek }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ ucwords(str_replace('-', ' ', $type)) }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if ($project->status_persetujuan == 'disetujui')
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                    Disetujui Penuh
                                                </span>
                                            @else
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                                    Menunggu Admin Berikutnya
                                                </span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="px-6 py-4 text-center text-gray-500">Anda belum menyetujui proyek apapun.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>