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
                                            <form action="{{ route('admin.projects.decide', ['type' => $type, 'id' => $project->id]) }}" method="POST">
                                                @csrf
                                                <div class="flex items-center gap-4">
                                                    <button type="submit" name="decision" value="setuju" class="px-4 py-2 bg-green-500 text-white text-xs font-semibold rounded-md hover:bg-green-600">Setuju</button>
                                                    <button type="button" onclick="document.getElementById('form-tolak-{{$type}}-{{$project->id}}').style.display='block'" class="px-4 py-2 bg-red-500 text-white text-xs font-semibold rounded-md hover:bg-red-600">Tolak</button>
                                                </div>
                                                <div id="form-tolak-{{$type}}-{{$project->id}}" style="display: none;" class="mt-2">
                                                    <textarea name="catatan_penolakan" rows="2" class="w-full border-gray-300 rounded-md text-sm" placeholder="Tambahkan catatan penolakan..."></textarea>
                                                    <button type="submit" name="decision" value="tolak" class="mt-1 px-4 py-1 bg-red-500 text-white text-xs font-semibold rounded-md hover:bg-red-600">Konfirmasi Tolak</button>
                                                </div>
                                            </form>
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
                </div>
            </div>
        </div>
    </div>
</x-app-layout>