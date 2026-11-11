<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="@yield('description', site_setting('meta_description'))">
    <meta name="theme-color" content="#126562">
    <title>@yield('title', site_setting('meta_title') ?: site_setting('website_name'))</title>
    <link rel="icon" href="{{ site_asset('favicon', 'better-nexus/assets/brand/favicon.ico') }}">
    <link rel="apple-touch-icon" href="{{ asset('better-nexus/assets/brand/apple-touch-icon.png') }}">

    {{-- Bootstrap + custom CSS/JS load ONCE through Vite. --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="{{ asset('better-nexus/shared/forms.css') }}?v=2">
    <link rel="stylesheet" href="{{ asset('better-nexus/approved/client-feedback.css') }}?v=1">
    {{-- AOS visual effects, limited to content sections. Fallback is bundled for offline use. --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css">
    <link rel="stylesheet" href="{{ asset('better-nexus/experience/landing-aos-refine.css') }}?v=20261111h">
    @stack('styles')
    <link rel="stylesheet" href="{{ asset('better-nexus/frontend/heading-system.css') }}?v=20261111c">
    @include('frontend.partials.va-styles')
    {{-- Experience refinements are scoped to #main; shared header is unchanged. --}}
    <link rel="stylesheet" href="{{ asset('better-nexus/experience/landing.css') }}?v=20261111e">
    {{-- Scoped landing content refinements loaded last, never restyle the shared header. --}}
    <link rel="stylesheet" href="{{ asset('better-nexus/experience/intro-motion-final.css') }}?v=20261111j">
</head>
<body class="@yield('body-class')">
    <a class="bn2-skip" href="#main">Skip to content</a>
    @include('frontend.partials.header')

    <main id="main">
        @yield('content')
    </main>

    @include('frontend.partials.footer')
    <button class="bn2-to-top" type="button" aria-label="Back to top">↑</button>
    <x-ui.toasts />
    <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js" defer></script>
    @stack('scripts')
    <script src="{{ asset('better-nexus/experience/landing-aos-refine.js') }}?v=20261111h" defer></script>
    <script src="{{ asset('better-nexus/experience/landing.js') }}?v=20261111e" defer></script>
    <script src="{{ asset('better-nexus/experience/intro-motion-final.js') }}?v=20261111j" defer></script>
</body>
</html>
