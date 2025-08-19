<x-app-layout>

    @push('content-header')
        <x-content-header
            :proyek="$proyek"
            tahapan="Sertifikat"
        />
    @endpush

    <div class="p-4 sm:p-2 max-w-7xl mx-auto space-y-4">

        <!-- Peta BHUMI -->
        <div class="bg-white p-4 sm:p-6 rounded-lg shadow-md">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div class="flex items-center gap-4">
                    <div class="flex-shrink-0 bg-blue-100 text-blue-600 p-3 rounded-full">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l5.447 2.724A1 1 0 0021 16.382V5.618a1 1 0 00-1.447-.894L15 7m-6 10V7m0 0l6-3m0 0l6 3m-6-3v10" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-gray-800">Peta Interaktif Bhumi ATR/BPN</h3>
                        <p class="text-sm text-gray-500 mt-1">
                            Buka peta resmi untuk melihat detail persil tanah dan wilayah.
                        </p>
                    </div>
                </div>

                <div class="mt-4 sm:mt-0 flex-shrink-0">
                    <a href="https://bhumi.atrbpn.go.id/peta" target="_blank" 
                    class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold px-4 py-2 rounded-md transition shadow">
                        <span>Buka Peta</span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                        </svg>
                    </a>
                </div>
            </div>
        </div>

    </div>

</x-app-layout>
