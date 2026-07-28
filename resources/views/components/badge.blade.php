@props([
    'type' => 'secondary',
    'value' => ''
])

@php
    $typeClasses = [
        'active' => 'bg-success',
        'inactive' => 'bg-secondary',
        'available' => 'bg-success',
        'issued' => 'bg-primary',
        'reserved' => 'bg-warning text-dark',
        'lost' => 'bg-danger',
        'damaged' => 'bg-dark',
        'maintenance' => 'bg-info text-dark',
    ];

    $badgeClass = $typeClasses[strtolower($type)] ?? 'bg-' . $type;
@endphp

<span class="badge {{ $badgeClass }} px-2 py-1 text-uppercase" style="font-size: 0.75rem;">
    {{ $value ?: $type }}
</span>