@props(['status'])

@php
    $classes = match ($status->value ?? $status) {
        'new' => 'bg-blue-100 text-blue-800',
        'in_progress' => 'bg-yellow-100 text-yellow-800',
        'resolved' => 'bg-green-100 text-green-800',
        default => 'bg-gray-100 text-gray-800',
    };
@endphp

<span class="px-2 inline-flex text-xs leading-5 whitespace-nowrap font-semibold rounded-full {{ $classes }}">
    {{ is_string($status) ? ucfirst(str_replace('_', ' ', $status)) : $status->label() }}
</span>
