@props(['tone' => 'cream', 'id' => null])

@php
    $background = [
        'white' => 'bg-white',
        'cream' => 'bg-cream',
        'green' => 'bg-primary-50',
    ][$tone] ?? 'bg-cream';
@endphp

<section @if ($id) id="{{ $id }}" @endif class="{{ $background }} py-14 sm:py-20">
    <div class="mx-auto max-w-6xl px-4">
        {{ $slot }}
    </div>
</section>