{{-- ARCHIVED ORIGINAL DYNAMIC HERO. Restore this block and HomeController query to reactivate.

@push('styles')
    
    <link rel="stylesheet" href="{{ asset('better-nexus/hero/module.css') }}?v=1">
    <link rel="stylesheet" href="{{ asset('better-nexus/hero/original.css') }}?v=2">
@endpush
@if($hero?->is_active)
<section class="bn2-home-hero">
    @if($hero->show_video)
        <div class="bn8-hero-media" aria-hidden="true">
            <video class="bn8-hero-video" muted loop playsinline preload="metadata" poster="{{ asset('better-nexus/assets/media/connected-motion-poster.jpg') }}">
                <source src="{{ asset('better-nexus/assets/media/connected-motion.mp4') }}" type="video/mp4">
            </video>
        </div>
    @endif

    <div class="bn2-orbit">
        @foreach($hero->images as $image)
            @php
                $angle = ($loop->index / max(1, $hero->images->count())) * 2 * M_PI - 0.3;
                $x = number_format(cos($angle) * 540, 2, '.', '');
                $y = number_format(sin($angle) * 310, 2, '.', '');
                $rotation = (($loop->index % 3) - 1) * 7;
            @endphp
            <div class="bn2-orbit-card" style="--x:{{ $x }}px;--y:{{ $y }}px;--r:{{ $rotation }}deg;--bn4-i:{{ $loop->index }};--bn8-a:{{ $angle }}">
                <img src="{{ asset($image->path) }}" alt="{{ $image->alt }}" width="800" height="960" loading="eager" decoding="async">
            </div>
        @endforeach
    </div>

    <div class="bn2-container bn2-home-hero-copy">
        @if($hero->eyebrow)<span class="bn2-eyebrow">{{ $hero->eyebrow }}</span>@endif
        <h1>{{ $hero->title }}@if($hero->highlight)<br><em>{{ $hero->highlight }}</em>@endif</h1>
        @if($hero->description)<p>{!! nl2br(e($hero->description)) !!}</p>@endif
        @if($hero->primary_label && $hero->primary_url)
            <x-frontend.button :href="$hero->primary_url" class="bn2-button">{{ $hero->primary_label }} <span aria-hidden="true">↗</span></x-frontend.button>
        @endif
        @if($hero->secondary_label && $hero->secondary_url)
            <x-frontend.button :href="$hero->secondary_url" class="bn2-button" style="margin-left:8px">{{ $hero->secondary_label }} <span aria-hidden="true">↗</span></x-frontend.button>
        @endif
    </div>

    <div class="bn2-wave" aria-hidden="true">
        <svg viewBox="0 0 1440 100" preserveAspectRatio="none">
            <path d="M0 30Q180 100 360 45T720 45T1080 45T1440 45V100H0Z"></path>
            <path d="M0 55Q180 0 360 55T720 55T1080 55T1440 55V100H0Z"></path>
        </svg>
    </div>
    <button class="bn8-motion-toggle" type="button" aria-label="Play background motion" aria-pressed="false">
        <span aria-hidden="true">▶</span> <span class="bn8-motion-label">Play motion</span>
    </button>
</section>
@endif

--}}
<section class="bn-approved-film" aria-label="Remote specialists working together for your business">
    <img class="bn-approved-poster" src="{{ asset('better-nexus/approved/team-poster.webp') }}" width="1280" height="720" alt="A business team collaborating on a shared project" fetchpriority="high">
    {{-- Edited 28-second stock montage, Mikhail Nilov / Pexels 6563827 and 6563866. License: https://www.pexels.com/license/ --}}
    <video id="bn-approved-video" muted loop playsinline preload="none" poster="{{ asset('better-nexus/approved/team-poster.webp') }}" data-desktop="{{ asset('better-nexus/approved/team-desktop.mp4') }}" data-mobile="{{ asset('better-nexus/approved/team-mobile.mp4') }}" aria-label="Business planning and specialist collaboration"></video>
    <div class="bn-film-shade" aria-hidden="true"></div>
    <div class="bn-film-purpose">
        <span class="bn-film-kicker">BETTER NEXUS / REMOTE TALENT. REAL CONNECTION.</span>
        <p>Your work. The right expertise.</p>
        <div class="bn-film-capabilities"><span>Business support</span><span>Digital &amp; technology</span><span>Finance &amp; operations</span></div>
        <a href="{{ route('services.index') }}" class="bn-film-link">Discover your support <span aria-hidden="true">↗</span></a>
    </div>
    <a class="bn-film-scroll" href="#the-right-connection" aria-label="Discover Better Nexus">Scroll to discover <span aria-hidden="true">↓</span></a>
    <svg class="bn-film-wave" viewBox="0 0 1440 70" preserveAspectRatio="none" aria-hidden="true"><path d="M0 35Q250 85 540 38T1050 36T1440 26V70H0Z" fill="#d8f3ed"/></svg>
</section>