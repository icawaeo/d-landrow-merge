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

        <!-- Peta BHUMI -->
        <div class="bg-white p-4 sm:p-6 rounded shadow">
            <p class="text-gray-700 text-base mb-2">Klik tombol di bawah untuk membuka Peta BHUMI ATR/BPN:</p>
            <a href="https://bhumi.atrbpn.go.id/peta" target="_blank"
               class="inline-block bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">
                Buka Peta BHUMI
            </a>
        </div>

    </div>

</x-app-layout>
