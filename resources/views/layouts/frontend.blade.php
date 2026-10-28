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
    @stack('styles')
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
    @stack('scripts')
</body>
</html>
