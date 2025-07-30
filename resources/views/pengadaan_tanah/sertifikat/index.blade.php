<x-app-layout>

    <x-slot name="header">

        <div class="flex items-center gap-4">

            <a href="{{ url()->previous() }}" class="text-gray-500 hover:text-gray-700">

                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">

                    <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />

                </svg>

            </a>

            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Sertifikat</h2>

        </div>

    </x-slot>


    <div class="p-4 sm:p-6 max-w-7xl mx-auto space-y-4">

        <!-- Peta -->

        <div class="bg-white p-4 sm:p-6 rounded shadow">

            <iframe src="https://www.google.com/maps/embed?pb=" width="100%" height="300" class="rounded w-full"></iframe>

        </div>


        <!-- Keterangan -->

        <div>

            <p class="text-gray-700 text-base">Silakan masukkan data koordinat sertifikat yang ingin Anda cari:</p>

        </div>


        <!-- Form Search -->

        <form method="POST" action="{{ route('sertifikat.search', 1) }}">

            @csrf

            <div class="grid gap-4 sm:grid-cols-2 md:grid-cols-4">

                <div class="flex flex-col">

                    <label for="no_tip" class="text-sm text-gray-700 mb-1">No TIP</label>

                    <input type="text" name="no_tip" id="no_tip" placeholder="Contoh: 12345"

                        class="border px-3 py-2 rounded w-full text-base" required>

                </div>


                <div class="flex flex-col">

                    <label for="x" class="text-sm text-gray-700 mb-1">Koordinat X</label>

                    <input type="text" name="x" id="x" placeholder="Contoh: 456789"

                        class="border px-3 py-2 rounded w-full text-base" required>

                </div>


                <div class="flex flex-col">

                    <label for="y" class="text-sm text-gray-700 mb-1">Koordinat Y</label>

                    <input type="text" name="y" id="y" placeholder="Contoh: 987654"

                        class="border px-3 py-2 rounded w-full text-base" required>

                </div>


                <div class="flex items-end">

                    <button type="submit"

                        class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded text-base w-full">CARI</button>

                </div>

            </div>

        </form>


        <!-- Hasil -->

        @isset($result)

            <div class="bg-white p-4 sm:p-6 rounded shadow">

                <h4 class="font-semibold mb-2 text-lg">Hasil Pencarian</h4>

                <p><strong>No TIP:</strong> {{ $result->no_tip }}</p>

                <p><strong>Koordinat:</strong> {{ $result->x }}, {{ $result->y }}</p>


                @if ($result->file_path)

                    <a href="{{ Storage::url($result->file_path) }}" target="_blank"

                        class="text-blue-600 hover:underline block mt-2">Lihat Sertifikat</a>

                @else

                    <form action="{{ route('sertifikat.upload', $result->id) }}" method="POST" enctype="multipart/form-data" class="mt-2">

                        @csrf

                        <label for="file" class="cursor-pointer bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600 inline-block">Upload Sertifikat</label>

                        <input type="file" name="file" id="file" class="hidden" onchange="this.form.submit()">

                    </form>

                @endif

            </div>

        @endisset

    </div>

</x-app-layout>