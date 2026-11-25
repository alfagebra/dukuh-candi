@props(['href', 'label' => 'Lihat selengkapnya'])

<div class="mt-10 text-center">
    <a href="{{ $href }}"
       class="inline-flex items-center gap-2 rounded-full border border-primary-700 bg-white px-7 py-3 text-sm font-semibold text-primary-800 transition hover:bg-primary-700 hover:text-white">
        {{ $label }} <span aria-hidden="true">&rarr;</span>
    </a>
</div>