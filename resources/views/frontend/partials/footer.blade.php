{{-- Footer styles are independent of the header and previous footer versions. --}}
<link rel="stylesheet" href="{{ asset('better-nexus/footer/footer.css') }}?v=20261029approved">
@php
    $footerLogo = site_asset('footer_logo');
    $brandName = site_setting('website_name') ?: 'Better Nexus';
    $socialIcons = [
        'linkedin' => ['LinkedIn', '<path d="M6 9v10M6 5v.1M10 19V9h4v2c1-3 6-3 6 2v6M14 13v6"/>'],
        'instagram' => ['Instagram', '<rect x="3" y="3" width="18" height="18" rx="5"/><circle cx="12" cy="12" r="4"/><path d="M17.5 6.5h.01"/>'],
        'facebook' => ['Facebook', '<path d="M14 21V12h3l.5-4H14V6c0-1 .5-2 2-2h2V1h-3c-3 0-5 2-5 5v2H7v4h3v9"/>'],
        'youtube' => ['YouTube', '<rect x="2" y="5" width="20" height="14" rx="4"/><path d="m10 9 5 3-5 3Z"/>'],
        'x_url' => ['X', '<path d="m4 3 16 18M20 3 4 21M3 3h5l13 18h-5Z"/>'],
    ];
    $footerSocials = array_filter($socialIcons, fn ($key) => (bool) site_setting($key), ARRAY_FILTER_USE_KEY);
@endphp
<footer class="bn-mock-footer" id="bn-approved-footer" aria-label="Website footer">
    <div class="bn-mf-waves" aria-hidden="true"><svg viewBox="0 0 1440 100" preserveAspectRatio="none"><path d="M0 0H1440V25C1150 95 970 82 720 60S260 5 0 62Z" class="bn-mf-wave-light"/><path d="M0 45C260-15 450 50 720 72S1150 48 1440 15V100H0Z" class="bn-mf-wave-teal"/><path d="M0 83C260 10 440 62 720 85S1170 73 1440 48V100H0Z" class="bn-mf-wave-navy"/></svg></div>
    <svg class="bn-mf-orbits" viewBox="0 0 240 300" fill="none" aria-hidden="true"><ellipse cx="235" cy="150" rx="210" ry="135"/><ellipse cx="235" cy="150" rx="175" ry="110"/><ellipse cx="235" cy="150" rx="140" ry="85"/><circle cx="46" cy="92" r="4"/><circle cx="62" cy="190" r="4"/><circle cx="103" cy="230" r="4"/></svg>
    <div class="bn-mf-container">
        <div class="bn-mf-grid">
            <div class="bn-mf-brand-column">
                <a class="bn-mf-logo" href="{{ route('home') }}" aria-label="{{ $brandName }} home">
                    @if($footerLogo)<img class="bn-mf-custom-logo" src="{{ $footerLogo }}" alt="{{ $brandName }}" width="320" height="90" loading="lazy">
                    @else<img class="bn-mf-emblem" src="{{ asset('better-nexus/footer/emblem.webp') }}" alt="" width="80" height="80" loading="lazy"><img class="bn-mf-wordmark" src="{{ asset('better-nexus/footer/wordmark.webp') }}" alt="{{ $brandName }} — Refined Remote Talent" width="235" height="50" loading="lazy">@endif
                </a>
                @if(count($footerSocials))<div class="bn-mf-socials bn-mf-socials-desktop" aria-label="Social links">@foreach($footerSocials as $key => [$label,$icon])<a href="{{ site_setting($key) }}" target="_blank" rel="noopener noreferrer" aria-label="{{ $label }}"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">{!! $icon !!}</svg></a>@endforeach</div>@endif
            </div>
            <nav class="bn-mf-explore" aria-label="Footer navigation"><h2>Explore</h2><div class="bn-mf-nav-links"><a href="{{ route('home') }}">Home</a><a href="{{ route('about') }}">About us</a><a href="{{ route('services.index') }}">Services</a><a href="{{ route('blogs.index') }}">Blogs</a><a href="{{ route('contact-us') }}">Contact us</a></div></nav>
            <div class="bn-mf-contact"><h2>Get in touch</h2>
                @if(site_setting('contact_email'))<div class="bn-mf-contact-row"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true"><rect x="2" y="4" width="20" height="16" rx="2"/><path d="m3 5 9 7 9-7"/></svg><a href="mailto:{{ site_setting('contact_email') }}">{{ site_setting('contact_email') }}</a></div>@endif
                @if(site_setting('phone_primary') || site_setting('phone_secondary'))<div class="bn-mf-contact-row"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linejoin="round" aria-hidden="true"><path d="m7 3 3 5-3 3c1.7 3 3 4.3 6 6l3-3 5 3-1 4C10 22 2 14 3 4Z"/></svg><div>@foreach(['phone_primary','phone_secondary'] as $key)@if(site_setting($key))<a href="tel:{{ preg_replace('/[^0-9+]/', '', site_setting($key)) }}">{{ site_setting($key) }}</a>@endif @endforeach</div></div>@endif
                <a class="bn-mf-enquiry" href="{{ route('contact-us') }}#bn-contact-live">Send an enquiry <svg viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.3" aria-hidden="true"><path d="M3 13 13 3M3 3h10v10"/></svg></a>
            </div>
        </div>
        <div class="bn-mf-bottom">
            @if(count($footerSocials))<div class="bn-mf-socials bn-mf-socials-mobile" aria-label="Social links">@foreach($footerSocials as $key => [$label,$icon])<a href="{{ site_setting($key) }}" target="_blank" rel="noopener noreferrer" aria-label="{{ $label }}"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">{!! $icon !!}</svg></a>@endforeach</div>@endif
            <p>© {{ date('Y') }} {{ site_setting('copyright_text') ?: $brandName . '. All rights reserved.' }}</p><a class="bn-mf-top" href="#main">Back to top <span aria-hidden="true">↑</span></a>
        </div>
    </div>
</footer>
