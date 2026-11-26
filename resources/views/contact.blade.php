@php
    $siteName = $profile?->name ?? config('site.name');

    $socials = array_filter([
        'Instagram' => $profile?->instagram,
        'Facebook' => $profile?->facebook,
        'YouTube' => $profile?->youtube,
        'TikTok' => $profile?->tiktok,
    ]);

    $mapUrl = $profile?->map_embed_url;

    $icons = [
        'address' => 'M15 10.5a3 3 0 11-6 0 3 3 0 016 0z M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z',
        'phone' => 'M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 002.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 01-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 00-1.091-.852H4.5A2.25 2.25 0 002.25 4.5v2.25z',
        'whatsapp' => 'M20.25 8.511c.884.284 1.5 1.128 1.5 2.097v4.286c0 1.136-.847 2.1-1.98 2.193-.34.027-.68.052-1.02.072v3.091l-3-3c-1.354 0-2.694-.055-4.02-.163a2.115 2.115 0 01-.825-.242m9.345-8.334a2.126 2.126 0 00-.476-.095 48.64 48.64 0 00-8.048 0c-1.131.094-1.976 1.057-1.976 2.192v4.286c0 .837.46 1.58 1.155 1.951m9.345-8.334V6.637c0-1.621-1.152-3.026-2.76-3.235A48.455 48.455 0 0011.25 3c-2.115 0-4.198.137-6.24.402-1.608.209-2.76 1.614-2.76 3.235v6.226c0 1.621 1.152 3.026 2.76 3.235.577.075 1.157.14 1.74.194V21l4.155-4.155',
        'email' => 'M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75',
        'social' => 'M13.19 8.688a4.5 4.5 0 011.242 7.244l-4.5 4.5a4.5 4.5 0 01-6.364-6.364l1.757-1.757m13.35-.622l1.757-1.757a4.5 4.5 0 00-6.364-6.364l-4.5 4.5a4.5 4.5 0 001.242 7.244',
    ];
@endphp

<x-layouts.app title="Kontak" :description="'Alamat, telepon, WhatsApp, dan media sosial ' . $siteName . '.'">

    <style>
        .kontak-grid {
            display: grid;
            gap: 2rem;
            align-items: stretch;
            max-width: 72rem;
            margin: 0 auto;
            padding: 3.5rem 1rem 0;
        }

        @media (min-width: 1024px) {
            .kontak-grid { grid-template-columns: 1fr 1fr; }
        }

        .kontak-list {
            display: flex;
            flex-direction: column;
            gap: 0.75rem;
        }

        .kontak-pair {
            display: grid;
            gap: 0.75rem;
            flex: 1 1 auto;
        }

        @media (min-width: 640px) {
            .kontak-pair { grid-template-columns: 1fr 1fr; }
        }

        .kontak-card {
            position: relative;
            display: flex;
            align-items: center;
            gap: 0.875rem;
            flex: 1 1 auto;
            padding: 1rem 1.125rem;
            overflow: hidden;
            text-decoration: none;
            color: #26231f;
            background: rgba(255, 255, 255, 0.92);
            border: 1px solid rgba(255, 255, 255, 0.8);
            border-radius: 1rem;
            box-shadow: 0 0 0 1px #dcebd6, 0 6px 18px rgba(35, 63, 35, 0.10);
            transition: transform 0.25s ease, box-shadow 0.25s ease;
        }

        a.kontak-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 0 0 1px #dcebd6, 0 12px 26px rgba(35, 63, 35, 0.16);
        }

        .kontak-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, #d99a24, #3f7a3a);
        }

        .kontak-icon {
            display: flex;
            flex: 0 0 auto;
            align-items: center;
            justify-content: center;
            width: 2.5rem;
            height: 2.5rem;
            border-radius: 0.75rem;
            color: #ffffff;
            background: #336331;
            box-shadow: 0 3px 8px rgba(35, 63, 35, 0.25);
            transition: background-color 0.2s ease, color 0.2s ease;
        }

        a.kontak-card:hover .kontak-icon {
            background: #d99a24;
            color: #2f1c11;
        }

        .kontak-icon svg {
            width: 1.25rem;
            height: 1.25rem;
        }

        .kontak-body { min-width: 0; }

        .kontak-label {
            margin: 0;
            font-size: 0.7rem;
            font-weight: 700;
            letter-spacing: 0.12em;
            line-height: 1;
            text-transform: uppercase;
            color: #b87a14;
        }

        .kontak-value {
            margin: 0.35rem 0 0;
            font-size: 1rem;
            font-weight: 700;
            line-height: 1.3;
            color: #233f23;
            word-break: break-word;
        }

        .kontak-value--plain {
            font-weight: 500;
            color: #26231f;
            white-space: pre-line;
        }

        .kontak-socials {
            display: flex;
            flex-wrap: wrap;
            gap: 0.5rem;
            margin: 0.5rem 0 0;
            padding: 0;
            list-style: none;
        }

        .kontak-socials a {
            display: inline-block;
            padding: 0.3rem 0.9rem;
            font-size: 0.875rem;
            font-weight: 600;
            text-decoration: none;
            color: #2b4f2a;
            background: #ffffff;
            border: 1px solid #b9d7ae;
            border-radius: 9999px;
            transition: background-color 0.2s ease, color 0.2s ease, border-color 0.2s ease;
        }

        .kontak-socials a:hover {
            color: #ffffff;
            background: #336331;
            border-color: #336331;
        }

        .kontak-map {
            position: relative;
            min-height: 22rem;
            overflow: hidden;
            background: #f1f7ef;
            border: 1px solid rgba(255, 255, 255, 0.8);
            border-radius: 1rem;
            box-shadow: 0 0 0 1px #dcebd6, 0 6px 18px rgba(35, 63, 35, 0.12);
        }

        @media (min-width: 1024px) {
            .kontak-map { min-height: 26rem; }
        }

        .kontak-map iframe {
            position: absolute;
            top: 0;
            right: 0;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 100%;
            border: 0;
        }
    </style>

    <x-page-header eyebrow="Kontak" :title="'Hubungi ' . $siteName" />

    <div class="kontak-grid">

        <div class="kontak-list">

            @if ($profile?->address)
                <div class="kontak-card">
                    <span class="kontak-icon">
                        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="{{ $icons['address'] }}" />
                        </svg>
                    </span>
                    <div class="kontak-body">
                        <p class="kontak-label">Alamat</p>
                        <p class="kontak-value kontak-value--plain">{{ $profile->address }}</p>
                    </div>
                </div>
            @endif

            @if ($profile?->phone || $profile?->whatsapp_url)
                <div class="kontak-pair">
                    @if ($profile?->phone)
                        <a href="tel:{{ preg_replace('/[^\d+]/', '', $profile->phone) }}" class="kontak-card">
                            <span class="kontak-icon">
                                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="{{ $icons['phone'] }}" />
                                </svg>
                            </span>
                            <div class="kontak-body">
                                <p class="kontak-label">Telepon</p>
                                <p class="kontak-value">{{ $profile->phone }}</p>
                            </div>
                        </a>
                    @endif

                    @if ($profile?->whatsapp_url)
                        <a href="{{ $profile->whatsapp_url }}" target="_blank" rel="noopener" class="kontak-card">
                            <span class="kontak-icon">
                                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="{{ $icons['whatsapp'] }}" />
                                </svg>
                            </span>
                            <div class="kontak-body">
                                <p class="kontak-label">WhatsApp</p>
                                <p class="kontak-value">{{ $profile->whatsapp }}</p>
                            </div>
                        </a>
                    @endif
                </div>
            @endif

            @if ($profile?->email)
                <a href="mailto:{{ $profile->email }}" class="kontak-card">
                    <span class="kontak-icon">
                        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="{{ $icons['email'] }}" />
                        </svg>
                    </span>
                    <div class="kontak-body">
                        <p class="kontak-label">Email</p>
                        <p class="kontak-value">{{ $profile->email }}</p>
                    </div>
                </a>
            @endif

            @if ($socials)
                <div class="kontak-card" style="align-items: flex-start;">
                    <span class="kontak-icon">
                        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="{{ $icons['social'] }}" />
                        </svg>
                    </span>
                    <div class="kontak-body">
                        <p class="kontak-label">Media Sosial</p>
                        <ul class="kontak-socials">
                            @foreach ($socials as $label => $url)
                                <li><a href="{{ $url }}" target="_blank" rel="noopener">{{ $label }}</a></li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif

        </div>

        @if ($mapUrl)
            <div class="kontak-map">
                <iframe src="{{ $mapUrl }}"
                        title="Peta lokasi {{ $siteName }}"
                        loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade"
                        allowfullscreen></iframe>
            </div>
        @endif
    </div>
</x-layouts.app>