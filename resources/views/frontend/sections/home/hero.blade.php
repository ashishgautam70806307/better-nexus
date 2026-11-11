{{-- Video-only hero. No poster <picture> or poster attribute: never flash a still image during loading. --}}
<section class="bn-clean-video-hero" aria-label="Better Nexus virtual assistant video">
    <video class="bn-clean-video" data-bn-clean-video
           data-desktop="{{ $heroDesktopVideo ?: asset('better-nexus/videos/virtual-assistant-desktop.mp4') }}"
           data-mobile="{{ $heroMobileVideo ?: asset('better-nexus/videos/virtual-assistant-mobile.mp4') }}"
           autoplay muted loop playsinline preload="auto" aria-hidden="true"></video>
</section>
