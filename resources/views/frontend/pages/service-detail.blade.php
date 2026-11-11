@extends('layouts.frontend')
@section('title', $service['title'].' | '.site_setting('website_name'))
@section('description', $service['summary'])
@push('styles')
<link rel="stylesheet" href="{{ asset('better-nexus/services/service-phase-one.css') }}?v=20261111a">
<link rel="stylesheet" href="{{ asset('better-nexus/services/service-phase-three.css') }}?v=20261111c">
<link rel="stylesheet" href="{{ asset('better-nexus/services/service-unique-editorial.css') }}?v=20261111d">
<link rel="stylesheet" href="{{ asset('better-nexus/services/service-phase-five-qa.css') }}?v=20261111e">
@endpush
@section('content')
<div class="va-page va-service-detail bn6-service bn-experience-detail bn-phase-two-detail bn-unique-service bn-unique-{{ $slug }}">
    <section class="va-section va-lead bn-experience-detail-hero">
        <div class="va-wrap va-split">
            <div class="bn-experience-detail-copy">
                <nav class="va-crumb" aria-label="Breadcrumb">
                    <a href="{{ route('home') }}">Home</a><span aria-hidden="true">/</span>
                    <a href="{{ route('services.index') }}">Services</a><span aria-hidden="true">/</span>
                    <span aria-current="page">{{ $service['title'] }}</span>
                </nav>
                <span class="va-kicker">VIRTUAL ASSISTANT SERVICES</span>
                <h1>{{ $service['title'] }}</h1>
                <p>{{ $service['intro'] }}</p>
                <div class="bn-experience-detail-actions">
                    <a class="va-button" href="{{ route('contact-us', ['subject' => $service['title']]) }}#bn-contact-live">Discuss your requirements <span aria-hidden="true">↗</span></a>
                    <a class="va-card-link" href="#bn-service-editorial">Explore this service ↓</a>
                </div>
            </div>
            <figure class="bn-experience-detail-photo">
                <img class="va-art" src="{{ asset($service['detail_photo'] ?? $service['photo']) }}" width="900" height="560"
                     alt="" fetchpriority="high" decoding="async">
                <figcaption>Practical support, built around your workflow.</figcaption>
            </figure>
        </div>
    </section>
    {{-- All seven slugs are allowlisted by the existing controller/config. No dynamic file paths from request input. --}}
    @include('frontend.pages.service-editorial.'. $slug)
</div>
@endsection
