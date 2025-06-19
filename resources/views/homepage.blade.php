<x-app-layout>
    {{-- Slot header Jetstream --}}
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Homepage') }}
        </h2>
    </x-slot>

    {{-- Wrapper Sidebar + Konten --}}
    <div class="flex min-h-screen">
        {{-- Sidebar --}}
        <x-sidebar />

        {{-- Konten Utama --}}
        <main class="flex-1 p-6 bg-gray-100">
            
            {{-- Salam --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-gray-900">
                    Selamat datang kembali, <strong>{{ Auth::user()->name }}</strong>!
                </div>
            </div>

            {{-- Cards --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-600">Total Pengguna</h3>
                        <p class="text-3xl font-bold text-gray-900 mt-2">150</p>
                        <p class="text-sm text-gray-500 mt-1">Pengguna terdaftar</p>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-600">Laporan Masuk</h3>
                        <p class="text-3xl font-bold text-blue-600 mt-2">32</p>
                        <p class="text-sm text-gray-500 mt-1">Laporan bulan ini</p>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-600">Laporan Selesai</h3>
                        <p class="text-3xl font-bold text-green-600 mt-2">28</p>
                        <p class="text-sm text-gray-500 mt-1">Status: Terselesaikan</p>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-600">Jadwal Pemeliharaan</h3>
                        <p class="text-3xl font-bold text-yellow-600 mt-2">5</p>
                        <p class="text-sm text-gray-500 mt-1">Jadwal akan datang</p>
                    </div>
                </div>
            </div>

            {{-- Table --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-xl font-semibold text-gray-800 mb-4">Aktivitas Laporan Terbaru</h3>
                    <div class="overflow-x-auto">
                        <table class="min-w-full bg-white">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID Laporan</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jenis Gangguan</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">LAP-00123</td>
                                    <td class="px-6 py-4 whitespace-nowrap">Listrik Padam</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Selesai</span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">18 Juni 2025</td>
                                </tr>
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">LAP-00124</td>
                                    <td class="px-6 py-4 whitespace-nowrap">Kabel Putus</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">Diproses</span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">19 Juni 2025</td>
                                </tr>
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">LAP-00125</td>
                                    <td class="px-6 py-4 whitespace-nowrap">Meteran Error</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">Baru</span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">19 Juni 2025</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </main>
    </div>
</x-app-layout>
