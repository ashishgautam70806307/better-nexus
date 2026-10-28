@props(['variant'=>'header'])
@php($logo = site_asset($variant === 'footer' ? 'footer_logo' : 'header_logo') ?: site_asset('header_logo'))
<a {{ $attributes->class(['better-nexus-brand','bn2-brand','bn8-brand','bn-approved-brand']) }} href="{{ route('home') }}" aria-label="{{ site_setting('website_name') }} home">
@if($logo)<img class="bn-approved-custom-logo" src="{{ $logo }}" alt="{{ site_setting('website_name') }}" width="180" height="65">
@else<img class="bn8-brand-emblem" src="{{ asset('better-nexus/approved/emblem.webp') }}" alt="" width="52" height="52"><img class="bn8-brand-wordmark" src="{{ asset('better-nexus/approved/wordmark.webp') }}" alt="{{ site_setting('website_name') }}" width="170" height="32">@endif
</a>