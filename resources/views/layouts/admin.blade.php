<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex, nofollow">
    <meta name="theme-color" content="#126562">
    <title>@yield('title', 'Workspace') | {{ site_setting('website_name') }}</title>
    <link rel="icon" href="{{ site_asset('favicon', 'better-nexus/assets/brand/favicon.ico') }}">
    {{-- Admin assets are independent of the public website and Vite dev server. --}}
    <link rel="stylesheet" href="{{ asset('better-nexus/admin/admin.css') }}?v=3">
    <script src="{{ asset('better-nexus/admin/premium.js') }}?v=7" defer></script>
    <link rel="stylesheet" href="{{ asset('better-nexus/admin/premium.css') }}?v=7">
    <link rel="stylesheet" href="{{ asset('better-nexus/shared/forms.css') }}?v=2">
    @stack('styles')
</head>
<body class="bn-admin @yield('body-class')">
    <a class="bn-admin-skip" href="#main">Skip to content</a>
    @yield('content')
    @stack('scripts')
</body>
</html>
