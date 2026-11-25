{{-- Jendela foto besar. Dibuka oleh tautan ber-atribut data-lightbox (lihat resources/js/app.js). --}}
<dialog id="lightbox" aria-label="Penampil foto"
        class="m-auto max-h-[95vh] w-[95vw] max-w-5xl overflow-visible bg-transparent p-0 backdrop:bg-black/85">
    <div class="relative flex flex-col items-center">
        <button type="button" data-lightbox-close aria-label="Tutup"
                class="absolute -top-2 right-0 z-10 flex h-10 w-10 items-center justify-center rounded-full bg-white/90 text-xl text-ink hover:bg-white">
            &times;
        </button>

        <img data-lightbox-image alt="" class="max-h-[78vh] w-auto max-w-full rounded-xl object-contain">

        <p data-lightbox-caption class="mt-3 text-center text-sm text-white"></p>
        <p data-lightbox-counter class="mt-1 text-xs text-white/70"></p>

        <button type="button" data-lightbox-prev aria-label="Foto sebelumnya"
                class="absolute left-0 top-1/2 flex h-11 w-11 -translate-y-1/2 items-center justify-center rounded-full bg-white/90 text-xl text-ink hover:bg-white">
            &lsaquo;
        </button>
        <button type="button" data-lightbox-next aria-label="Foto berikutnya"
                class="absolute right-0 top-1/2 flex h-11 w-11 -translate-y-1/2 items-center justify-center rounded-full bg-white/90 text-xl text-ink hover:bg-white">
            &rsaquo;
        </button>
    </div>
</dialog>