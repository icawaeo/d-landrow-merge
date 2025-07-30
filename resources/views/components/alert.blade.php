@props(['type' => 'success'])

@php
    $typeClasses = [
        'success' => 'bg-green-100 border border-green-300 text-green-800',
        'danger' => 'bg-red-100 border border-red-300 text-red-800',
        'warning' => 'bg-yellow-100 border border-yellow-300 text-yellow-800',
    ];

    $classes = $typeClasses[$type] ?? $typeClasses['success'];
@endphp

<div {{ $attributes->merge(['class' => $classes . ' px-4 py-3 rounded relative text-sm']) }} role="alert">
    {{ $slot }}
</div>