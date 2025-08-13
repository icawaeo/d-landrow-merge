<x-app-layout>

    @push('content-header')
        <x-content-header
            :proyek="$proyek"
            tahapan="Sertifikat"
        />
    @endpush

    <div class="p-4 sm:p-2 max-w-7xl mx-auto space-y-4">

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
