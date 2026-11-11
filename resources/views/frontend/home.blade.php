@extends('layouts.frontend')
@section('title', 'Virtual Assistant Services | '.site_setting('website_name'))
@section('description', 'Explore Better Nexus virtual assistant services for inbox management, customer support, marketing coordination, and daily business operations.')
@section('body-class', 'bn-video-home')
@push('styles')
<link rel="stylesheet" href="{{ asset('better-nexus/blogs/module.css') }}">
<link rel="stylesheet" href="{{ asset('better-nexus/hero/clean-video.css') }}?v=20261111f">
<link rel="stylesheet" href="{{ asset('better-nexus/hero/home-only-layout.css') }}?v=20261111f">
<link rel="stylesheet" href="{{ asset('better-nexus/hero/home-video-overlay.css') }}?v=20261111liquid1">
@endpush
@push('scripts')
<script src="{{ asset('better-nexus/hero/clean-video.js') }}?v=20261111m" defer></script>
<script src="{{ asset('better-nexus/hero/home-video-overlay.js') }}?v=20261111liquid1" defer></script>
@endpush
@section('content')
@include('frontend.sections.home.hero')
<section class="va-section va-lead va-home-intro bn-home-followup" aria-labelledby="bn-home-intro-title">
  <div class="va-wrap bn-intro-premium">
    <div class="bn-intro-copy" data-aos="fade-right" data-aos-duration="650">
      <span class="va-kicker">BETTER NEXUS</span>
      <h1 id="bn-home-intro-title">Virtual Assistant Services</h1>
      <span class="bn-intro-rule" aria-hidden="true"></span>
    </div>
    <div class="bn-intro-description" data-aos="fade-left" data-aos-duration="650" data-aos-delay="90">
      <p>Dependable virtual assistant support for inboxes, scheduling, customer conversations, content coordination and the details that keep your business moving.</p>
      <div class="va-home-actions">
        <a class="va-button" href="{{ route('contact-us') }}#bn-contact-live">Talk about your priorities <span aria-hidden="true">↗</span></a>
        <a class="va-card-link" href="#va-services">Explore our services <span aria-hidden="true">↓</span></a>
      </div>
    </div>
  </div>
</section>
<section class="va-section bn-home-connection" aria-labelledby="va-connection-heading"><div class="va-wrap va-split">
    <div data-aos="fade-right" data-aos-duration="700">
        <span class="va-kicker">THE RIGHT CONNECTION</span>
        <h2 id="va-connection-heading">Support that fits how you work.</h2>
        <p>Begin with a clear priority. Agree on ownership, approval steps, and a simple update routine, so you stay informed without managing every detail.</p>
        <a class="va-card-link" href="{{ route('about') }}">Get to know Better Nexus <span aria-hidden="true">↗</span></a>
    </div>
    <img data-aos="fade-left" data-aos-duration="750" class="va-art" src="{{ asset('better-nexus/assets/bn2/collaboration.jpg') }}" width="900" height="560" loading="lazy" decoding="async" alt="A small business team collaborating around a laptop">
</div></section>
<section class="va-section va-catalog bn-experience-catalog" id="va-services" aria-labelledby="bn-experience-services-heading"><div class="va-wrap">
    <span class="va-kicker" data-aos="fade-up">OUR SERVICES</span><h2 data-aos="fade-up" id="bn-experience-services-heading">Less on your plate. <span>More moving forward.</span></h2>
    <p>One connected team for the day-to-day work your business needs: clear ownership, thoughtful support, and more room to focus.</p>
    <x-frontend.va-cards :services="$services" />
</div></section>
@include('frontend.sections.home.working-together')
@include('frontend.sections.home.blogs')
@include('frontend.sections.home.questions')
<section class="va-section va-lead"><div class="va-wrap">
    <div class="va-callout va-final-cta">
        <div><span class="va-kicker">LET’S TALK</span><h2>What would you take off your plate first?</h2>
            <p>Tell us about one recurring task and we’ll help you work out what to hand over.</p></div>
        <a class="va-button" href="{{ route('contact-us') }}#bn-contact-live">Send an enquiry <span aria-hidden="true">↗</span></a>
    </div>
</div></section>
@endsection
