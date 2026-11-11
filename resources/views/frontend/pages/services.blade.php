@extends('layouts.frontend')
@section('title', 'Virtual Assistant Services | '.site_setting('website_name'))
@section('description', 'Discover Better Nexus virtual assistant services for administrative coordination, customer support, marketing, creative workflows, website content and everyday operations.')
@push('styles')
<link rel="stylesheet" href="{{ asset('better-nexus/services/service-phase-one.css') }}?v=20261111a">
@endpush
@section('content')
<div class="va-page bn-services-v2">
  <section class="bn-sv-hero va-section" aria-labelledby="bn-sv-heading">
    <div class="va-wrap bn-sv-hero-layout">
      <div class="bn-sv-hero-copy" data-aos="fade-right">
        <span class="va-kicker">BETTER NEXUS / OUR SERVICES</span>
        <h1 id="bn-sv-heading">Reliable support, tailored to your work.</h1>
        <p>Hand off recurring tasks with more clarity and less back-and-forth. Explore the services Better Nexus already offers, and find the right support for your team.</p>
        <a class="va-button" href="#bn-sv-grid">Explore all services <span aria-hidden="true">↓</span></a>
      </div>
      <div class="bn-sv-hero-photo" data-aos="fade-left">
        <img src="{{ asset('better-nexus/home-media/collaboration-2.webp') }}" width="960" height="620" alt="Colleagues discussing ongoing work at their office" fetchpriority="high" decoding="async">
        <span class="bn-sv-hero-note">A clear process. An easier day.</span>
      </div>
    </div>
  </section>
  <section class="va-section bn-experience-catalog bn-sv-catalog" id="bn-sv-grid" aria-labelledby="bn-sv-list-heading">
    <div class="va-wrap">
      <div class="bn-sv-section-head" data-aos="fade-up">
        <span class="va-kicker">WORK WE CAN SUPPORT</span>
        <h2 id="bn-sv-list-heading">Explore our services</h2>
        <p>Seven focused service areas. Select a card to see what we can help with and how to get started.</p>
      </div>
      <x-frontend.va-cards :services="$services" />
    </div>
  </section>
  <section class="va-section bn-sv-approach" aria-labelledby="bn-sv-approach-heading">
    <div class="va-wrap bn-sv-approach-grid">
      <div data-aos="fade-right"><span class="va-kicker">A PRACTICAL APPROACH</span><h2 id="bn-sv-approach-heading">Start with the work that matters most.</h2></div>
      <div data-aos="fade-left"><p>Tell us which tasks take up time, what tools you use, and where you need more consistency. We can discuss a workable scope, handoff process and communication routine before you begin.</p><a class="va-button" href="{{ route('contact-us') }}">Discuss your requirements <span aria-hidden="true">↗</span></a></div>
    </div>
  </section>
</div>
@endsection
