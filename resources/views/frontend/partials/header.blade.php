{{-- Styles are loaded here so no layout/app.css replacement is needed. --}}
@once
    <link rel="stylesheet" href="{{ asset('better-nexus/frontend/mobile-header.css') }}?v=20261029d">
@endonce
<link rel="stylesheet" href="{{ asset('better-nexus/approved/chrome.css') }}?v=20261029d">
<header class="bn2-header bn-approved-header" data-bn-responsive-header>
    <div class="bn2-container bn2-header-inner">
        <x-frontend.brand />
        <nav class="bn2-nav" aria-label="Main navigation"><a href="{{ route('home') }}"
                @if (request()->routeIs('home')) aria-current="page" @endif>Home</a><a href="{{ route('about') }}"
                @if (request()->routeIs('about')) aria-current="page" @endif>About Us</a>
            <details class="bn5-services-menu">
                <summary class="bn8-nav-services {{ request()->routeIs('services*') ? 'bn7-current-service' : '' }}">
                    Services <svg class="bn6-menu-chevron" viewBox="0 0 16 16" fill="none" aria-hidden="true">
                        <path d="m4 6 4 4 4-4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                            stroke-linejoin="round"></path>
                    </svg></summary>
                <div class="bn5-mega">
                    <div class="bn5-mega-head">
                        <div><span>FIND YOUR NEXT CONNECTION</span><strong>Expertise for the work ahead.</strong></div>
                        <a href="{{ route('services.index') }}"
                            @if (request()->routeIs('services.index')) aria-current="page" @endif>View all services <span
                                aria-hidden="true">↗</span></a>
                    </div>
                    <div class="bn5-mega-grid"><a
                            href="{{ route('services.show', ['slug' => 'administrative-tasks']) }}"
                            @if (request()->routeIs('services.show') && request()->route('slug') === 'administrative-tasks') aria-current="page" @endif><span
                                class="bn5-service-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"
                                    aria-hidden="true">
                                    <path d="M4 7h16v13H4z M8 7V4h8v3 M8 12h8"></path>
                                </svg></span><span><strong>Administrative Support</strong><small>Keep schedules,
                                    inboxes, and daily operations in sync.</small></span><b
                                aria-hidden="true">↗</b></a><a
                            href="{{ route('services.show', ['slug' => 'digital-marketing-services']) }}"
                            @if (request()->routeIs('services.show') && request()->route('slug') === 'digital-marketing-services') aria-current="page" @endif><span
                                class="bn5-service-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"
                                    aria-hidden="true">
                                    <path d="M4 10h4l11-5v14L8 14H4z M8 14l2 6"></path>
                                </svg></span><span><strong>Digital Marketing</strong><small>Connect your content,
                                    search, and social presence.</small></span><b aria-hidden="true">↗</b></a><a
                            href="{{ route('services.show', ['slug' => 'customer-support-and-experience']) }}"
                            @if (request()->routeIs('services.show') && request()->route('slug') === 'customer-support-and-experience') aria-current="page" @endif><span
                                class="bn5-service-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"
                                    aria-hidden="true">
                                    <path d="M4 13v-2a8 8 0 0116 0v2 M4 12h3v7H4z M17 12h3v7h-3z"></path>
                                </svg></span><span><strong>Customer Experience</strong><small>Thoughtful answers and
                                    consistent customer care.</small></span><b aria-hidden="true">↗</b></a><a
                            href="{{ route('services.show', ['slug' => 'website-revamp-and-optimization']) }}"
                            @if (request()->routeIs('services.show') && request()->route('slug') === 'website-revamp-and-optimization') aria-current="page" @endif><span
                                class="bn5-service-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"
                                    aria-hidden="true">
                                    <path d="M3 5h18v14H3z M3 9h18 M8 13l-2 2 2 2 M16 13l2 2-2 2"></path>
                                </svg></span><span><strong>Web &amp; Optimization</strong><small>Clearer websites,
                                    purposeful design, better journeys.</small></span><b aria-hidden="true">↗</b></a><a
                            href="{{ route('services.show', ['slug' => 'creative-services']) }}"
                            @if (request()->routeIs('services.show') && request()->route('slug') === 'creative-services') aria-current="page" @endif><span
                                class="bn5-service-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"
                                    aria-hidden="true">
                                    <path d="M12 3a6 6 0 00-4 10v4h8v-4a6 6 0 00-4-10 M9 21h6"></path>
                                </svg></span><span><strong>Creative &amp; Design</strong><small>Build a distinctive and
                                    consistent visual presence.</small></span><b aria-hidden="true">↗</b></a><a
                            href="{{ route('services.show', ['slug' => 'software-and-app-development']) }}"
                            @if (request()->routeIs('services.show') && request()->route('slug') === 'software-and-app-development') aria-current="page" @endif><span
                                class="bn5-service-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"
                                    aria-hidden="true">
                                    <path d="M8 7l-5 5 5 5 M16 7l5 5-5 5 M14 4l-4 16"></path>
                                </svg></span><span><strong>Software &amp; Apps</strong><small>Practical digital products
                                    built around your users.</small></span><b aria-hidden="true">↗</b></a><a
                            href="{{ route('services.show', ['slug' => 'finance-and-accounting']) }}"
                            @if (request()->routeIs('services.show') && request()->route('slug') === 'finance-and-accounting') aria-current="page" @endif><span
                                class="bn5-service-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"
                                    aria-hidden="true">
                                    <path d="M4 4h16v16H4z M8 8h8 M8 12h2 M14 12h2 M8 16h2 M14 16h2"></path>
                                </svg></span><span><strong>Finance &amp; Accounting</strong><small>Bring clarity to
                                    books, invoices, and reporting.</small></span><b aria-hidden="true">↗</b></a><a
                            href="{{ route('services.show', ['slug' => 'engineering-services']) }}"
                            @if (request()->routeIs('services.show') && request()->route('slug') === 'engineering-services') aria-current="page" @endif><span
                                class="bn5-service-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"
                                    aria-hidden="true">
                                    <path d="M3 19l16-16 2 2L5 21H3z M13 7l4 4 M6 14l4 4"></path>
                                </svg></span><span><strong>Engineering Support</strong><small>Extend your capacity for
                                    design and technical work.</small></span><b aria-hidden="true">↗</b></a></div>
                </div>
            </details>
            <a href="{{ route('blogs.index') }}"
                @if (request()->routeIs('blogs.*')) aria-current="page" @endif>Blogs</a><a
                href="{{ route('contact-us') }}"
                @if (request()->routeIs('contact-us')) aria-current="page" @endif>Contact Us</a>
        </nav>
      

        @auth
            <a href="{{ route('admin.dashboard') }}" class="bn2-button">
                Go to Dashboard <span
                                aria-hidden="true">↗</span>
            </a>
            @else
            <div class="bn2-header-action">
                        <x-frontend.button :href="route('contact-us') . '#contact-form'" class="bn2-button">Let’s talk <span
                                aria-hidden="true">↗</span></x-frontend.button>
                    </div>
            @endauth
                        
                    
        {{-- Native details works on touch and even without JavaScript. --}}
        <details class="bn-mobile-navigation" data-bn-mobile-menu>
            <summary class="bn-mobile-toggle" aria-label="Open navigation" aria-controls="bn2-mobile-nav">
                <span class="bn-mobile-toggle-lines" aria-hidden="true"><span></span><span></span><span></span></span>
            </summary>
            <nav id="bn2-mobile-nav" class="bn-mobile-panel" aria-label="Mobile navigation">
                <div class="bn-mobile-panel-heading"><span>EXPLORE BETTER NEXUS</span><span class="bn-mobile-panel-dot" aria-hidden="true"></span></div>
                <a class="bn-mobile-link" href="{{ route('home') }}" @if(request()->routeIs('home')) aria-current="page" @endif><span>Home</span><span aria-hidden="true">↗</span></a>
                <a class="bn-mobile-link" href="{{ route('about') }}" @if(request()->routeIs('about')) aria-current="page" @endif><span>About Us</span><span aria-hidden="true">↗</span></a>
                <details class="bn-mobile-services" @if(request()->routeIs('services.*')) open @endif>
                    <summary @class(['bn-mobile-link', 'is-current' => request()->routeIs('services.*')])><span>Services</span><svg viewBox="0 0 16 16" width="16" height="16" fill="none" aria-hidden="true"><path d="m4 6 4 4 4-4" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/></svg></summary>
                    <div class="bn-mobile-service-list">
                        <a class="bn-mobile-all-services" href="{{ route('services.index') }}" @if(request()->routeIs('services.index')) aria-current="page" @endif><span>View all services</span><span aria-hidden="true">↗</span></a>
                        <a href="{{ route('services.show', ['slug' => 'administrative-tasks']) }}"
                           @if(request()->routeIs('services.show') && request()->route('slug') === 'administrative-tasks') aria-current="page" @endif>
                            <span>Administrative Support</span><span aria-hidden="true">↗</span>
                        </a>
                        <a href="{{ route('services.show', ['slug' => 'digital-marketing-services']) }}"
                           @if(request()->routeIs('services.show') && request()->route('slug') === 'digital-marketing-services') aria-current="page" @endif>
                            <span>Digital Marketing</span><span aria-hidden="true">↗</span>
                        </a>
                        <a href="{{ route('services.show', ['slug' => 'customer-support-and-experience']) }}"
                           @if(request()->routeIs('services.show') && request()->route('slug') === 'customer-support-and-experience') aria-current="page" @endif>
                            <span>Customer Experience</span><span aria-hidden="true">↗</span>
                        </a>
                        <a href="{{ route('services.show', ['slug' => 'website-revamp-and-optimization']) }}"
                           @if(request()->routeIs('services.show') && request()->route('slug') === 'website-revamp-and-optimization') aria-current="page" @endif>
                            <span>Web &amp; Optimization</span><span aria-hidden="true">↗</span>
                        </a>
                        <a href="{{ route('services.show', ['slug' => 'creative-services']) }}"
                           @if(request()->routeIs('services.show') && request()->route('slug') === 'creative-services') aria-current="page" @endif>
                            <span>Creative &amp; Design</span><span aria-hidden="true">↗</span>
                        </a>
                        <a href="{{ route('services.show', ['slug' => 'software-and-app-development']) }}"
                           @if(request()->routeIs('services.show') && request()->route('slug') === 'software-and-app-development') aria-current="page" @endif>
                            <span>Software &amp; Apps</span><span aria-hidden="true">↗</span>
                        </a>
                        <a href="{{ route('services.show', ['slug' => 'finance-and-accounting']) }}"
                           @if(request()->routeIs('services.show') && request()->route('slug') === 'finance-and-accounting') aria-current="page" @endif>
                            <span>Finance &amp; Accounting</span><span aria-hidden="true">↗</span>
                        </a>
                        <a href="{{ route('services.show', ['slug' => 'engineering-services']) }}"
                           @if(request()->routeIs('services.show') && request()->route('slug') === 'engineering-services') aria-current="page" @endif>
                            <span>Engineering Support</span><span aria-hidden="true">↗</span>
                        </a>
                    </div>
                </details>
                <a class="bn-mobile-link" href="{{ route('blogs.index') }}" @if(request()->routeIs('blogs.*')) aria-current="page" @endif><span>Blogs</span><span aria-hidden="true">↗</span></a>
                <a class="bn-mobile-link" href="{{ route('contact-us') }}" @if(request()->routeIs('contact-us')) aria-current="page" @endif><span>Contact Us</span><span aria-hidden="true">↗</span></a>
                <a class="bn-mobile-cta" href="{{ route('contact-us') }}#contact-form"><span>Let’s talk</span><span aria-hidden="true">↗</span></a>
            </nav>
        </details>
    </div>
</header>
@once
    <script src="{{ asset('better-nexus/frontend/mobile-header.js') }}?v=20261029d" defer></script>
@endonce
