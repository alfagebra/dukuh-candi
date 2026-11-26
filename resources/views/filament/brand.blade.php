@php
    $site = \App\Models\Profile::cached();
    $name = $site?->name ?? config('site.name', 'Dukuh Candi');
@endphp

<div class="dukuh-brand">
    @if ($site?->logo_url)
        <img src="{{ $site->logo_url }}" alt="" class="dukuh-brand__logo">
    @else
        <span class="dukuh-brand__logo" aria-hidden="true">{{ mb_strtoupper(mb_substr($name, 0, 1)) }}</span>
    @endif
    <span class="dukuh-brand__name">{{ $name }}</span>
</div>