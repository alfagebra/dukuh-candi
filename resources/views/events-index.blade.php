<x-layouts.app title="Agenda" description="Jadwal kegiatan dukuh yang akan datang.">
    <x-page-header eyebrow="Agenda" title="Agenda Kegiatan" subtitle="Kegiatan dukuh yang akan datang." />

    <div class="mx-auto max-w-4xl px-4 pt-14">
        @if ($events->isEmpty())
            <p class="rounded-2xl border border-dashed border-primary-200 bg-white p-10 text-center text-muted">
                Belum ada agenda mendatang.
            </p>
        @else
            <div class="space-y-4">
                @foreach ($events as $event)
                    <x-event-card :event="$event" :show-description="true" />
                @endforeach
            </div>
        @endif
    </div>
</x-layouts.app>