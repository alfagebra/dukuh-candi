@php $site = \App\Models\Profile::cached(); @endphp

<p class="dukuh-login-intro">
    Masuk untuk mengelola konten website{{ $site?->name ? ' ' . $site->name : '' }}.
</p>