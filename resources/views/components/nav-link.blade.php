@props(['active'])

@php
// Kondisi untuk tautan aktif dan tidak aktif
$classes = ($active ?? false)
            // Kelas untuk tautan AKTIF: Teks putih dengan garis bawah putih
            ? 'inline-flex items-center px-1 pt-1 border-b-2 border-white text-sm font-medium leading-5 text-white focus:outline-none transition duration-150 ease-in-out'
            // Kelas untuk tautan TIDAK AKTIF
            : 'inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium leading-5 text-gray-300 hover:text-teal-400 hover:border-gray-100 focus:outline-none focus:text-gray-600 focus:border-gray-200 transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>