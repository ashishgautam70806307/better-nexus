@extends('layouts.frontend')
@section('title', 'About Better Nexus | Virtual Assistant Services')
@section('description', 'Meet Better Nexus: practical virtual assistant services designed to simplify everyday business work with clear responsibilities and dependable communication.')
@push('styles')
<link rel="stylesheet" href="{{ asset('better-nexus/blogs/module.css') }}">
<link rel="stylesheet" href="{{ asset('better-nexus/about/refined.css') }}?v=1">
@endpush
@section('content')
<div class="va-page bn-about-new">
  <section class="bn-about-hero"><div class="va-wrap bn-about-hero-grid">
    <div><span class="bn-about-eyebrow">ABOUT BETTER NEXUS</span><h1>More space for the work that matters.</h1><p>Better Nexus helps founders and growing teams delegate recurring work—from admin coordination and inboxes to customer conversations and business support.</p><p>Our approach is practical: understand the tasks, agree on responsibility, and create a working routine your team can rely on.</p><a class="bn-about-text-link" href="{{ route('services.index') }}">Explore our services <span aria-hidden="true">↗</span></a></div>
    <figure class="bn-about-hero-visual"><img src="{{ asset('better-nexus/home-media/connection-specialist.webp') }}" width="900" height="650" alt="Professional coordinating business work at a laptop" fetchpriority="high"><figcaption>Thoughtful support. Clear communication.</figcaption></figure>
  </div></section>
  <section class="bn-about-values"><div class="va-wrap"><div class="bn-about-heading"><div><span class="bn-about-eyebrow">OUR APPROACH</span><h2>Support that works with you.</h2></div><p>Three principles guide the way we organize work and keep collaboration straightforward.</p></div>
    <div class="bn-about-card-grid">
      <article class="bn-about-card"><div class="bn-about-card-top"><span>01 / CLARITY</span><span class="bn-about-card-symbol" aria-hidden="true">✓</span></div><h3>Know what's getting done</h3><p>Start with clear priorities, instructions and approval boundaries so each task has an owner.</p><div class="bn-about-card-end">Clear next steps</div></article>
      <article class="bn-about-card"><div class="bn-about-card-top"><span>02 / COMMUNICATION</span><span class="bn-about-card-symbol" aria-hidden="true">↗</span></div><h3>Stay in the loop</h3><p>Agree on useful updates and escalation points without adding unnecessary meetings.</p><div class="bn-about-card-end">Consistent check-ins</div></article>
      <article class="bn-about-card"><div class="bn-about-card-top"><span>03 / FLEXIBILITY</span><span class="bn-about-card-symbol" aria-hidden="true">◎</span></div><h3>Build around your needs</h3><p>Begin with the work that matters most and revise the scope as business priorities change.</p><div class="bn-about-card-end">Practical collaboration</div></article>
    </div>
  </div></section>
  <section class="bn-about-process"><div class="va-wrap"><div class="bn-about-heading"><div><span class="bn-about-eyebrow">HOW WE WORK TOGETHER</span><h2>A better handoff, step by step.</h2></div><p>A manageable process makes it easier to start, stay aligned and improve over time.</p></div>
    <div class="bn-about-process-grid"><img class="bn-about-process-photo" src="{{ asset('better-nexus/home-media/process-kickoff.webp') }}" width="900" height="900" alt="Colleagues working together around a laptop" loading="lazy">
      <ol class="bn-about-process-list"><li><b>01</b><div><h3>Share your priorities</h3><p>Tell us what repeats, the tools you use and the outcomes you need.</p></div></li><li><b>02</b><div><h3>Agree on ownership</h3><p>Define what can be handled independently and what needs approval.</p></div></li><li><b>03</b><div><h3>Start with a clear routine</h3><p>Set instructions, updates and realistic expectations for the first tasks.</p></div></li><li><b>04</b><div><h3>Review and refine</h3><p>Check what works and adjust the handoff as your needs evolve.</p></div></li></ol>
    </div>
  </div></section>
  <section class="bn-about-cta"><div class="va-wrap bn-about-cta-row"><div><span class="bn-about-eyebrow">START THE CONVERSATION</span><h2>What could you delegate this week?</h2><p>Tell us where you need an extra pair of hands.</p></div><a href="{{ route('contact-us') }}">Let's talk <span aria-hidden="true">↗</span></a></div></section>
  @if($latestArticles->isNotEmpty())
  <section class="bn-about-articles"><div class="va-wrap"><span class="bn-about-eyebrow">FROM THE BLOG</span><h2>More from Better Nexus</h2><div class="va-cards">@foreach($latestArticles as $blog)<x-frontend.blog-card :blog="$blog" />@endforeach</div></div></section>
  @endif
</div>
@endsection
