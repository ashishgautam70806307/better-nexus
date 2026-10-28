@extends('layouts.frontend')
@section('title', 'Contact Us | '.site_setting('website_name'))
@section('description', site_setting('contact_intro'))
@push('styles')<link rel="stylesheet" href="{{ asset('better-nexus/enquiries/contact.css') }}?v=5">@endpush
@push('scripts')<script src="{{ asset('better-nexus/enquiries/contact.js') }}?v=5" defer></script>@endpush
@section('content')
<div class="bnc-page">
    <header class="bnc-hero"><div class="bn2-container">
        <span class="bnc-eyebrow">{{ site_setting('contact_eyebrow') }}</span>
        <h1>{{ site_setting('contact_heading') }}</h1>
        <p>{{ site_setting('contact_intro') }}</p>
    </div></header>
    <section class="bnc-main"><div class="bn2-container bnc-grid">
        <aside class="bnc-details">
            <span class="bnc-eyebrow">{{ site_setting('short_name') }} · {{ site_setting('tagline') }}</span>
            <h2>{{ site_setting('contact_sidebar_title') }}</h2>
            @if(site_setting('contact_email'))<div class="bnc-channel"><span>Email us</span><a href="mailto:{{ site_setting('contact_email') }}">{{ site_setting('contact_email') }}</a></div>@endif
            @if(site_setting('support_email'))<div class="bnc-channel"><span>Support</span><a href="mailto:{{ site_setting('support_email') }}">{{ site_setting('support_email') }}</a></div>@endif
            @foreach(['primary','secondary'] as $office)
                @if(site_setting('phone_'.$office))<div class="bnc-channel"><span>{{ site_setting('office_'.$office.'_name') }}</span><a href="tel:{{ preg_replace('/[^+0-9]/','',site_setting('phone_'.$office)) }}">{{ site_setting('phone_'.$office) }}</a></div>@endif
            @endforeach
            @if(site_setting('business_hours'))<div class="bnc-channel"><span>Business hours</span><p>{{ site_setting('business_hours') }}</p></div>@endif
            @if(site_setting('whatsapp'))<a class="bnc-whatsapp" href="https://wa.me/{{ preg_replace('/\D/','',site_setting('whatsapp')) }}" target="_blank" rel="noopener noreferrer">Chat on WhatsApp <span aria-hidden="true">↗</span></a>@endif
            <div class="bnc-socials">@foreach(['facebook'=>'Facebook','instagram'=>'Instagram','linkedin'=>'LinkedIn','youtube'=>'YouTube','x_url'=>'X'] as $key=>$label)@if(site_setting($key))<a href="{{ site_setting($key) }}" target="_blank" rel="noopener noreferrer">{{ $label }}</a>@endif @endforeach</div>
        </aside>
        <form id="bn-contact-live" class="bnc-form" method="POST" action="{{ route('contact.store') }}">
            @csrf
            <h2>{{ site_setting('contact_form_heading') }}</h2>
            <p class="bnc-form-intro">{{ site_setting('contact_form_intro') }}</p>
            <p class="bnc-required-note"><span aria-hidden="true">*</span> Required fields</p>
            <div class="bnc-fields">
                <div class="bnc-field"><label for="contact-name">Your name <span aria-hidden="true">*</span></label><input id="contact-name" name="name" autocomplete="name" minlength="2" maxlength="120" value="{{ old('name') }}" required placeholder="Full name" aria-describedby="name-error" @if($errors->has('name')) aria-invalid="true" @endif><small id="name-error" class="bnc-error" data-error="name">@error('name'){{ $message }}@enderror</small></div>
                <div class="bnc-field"><label for="contact-email">Email address <span aria-hidden="true">*</span></label><input id="contact-email" name="email" type="email" autocomplete="email" maxlength="255" value="{{ old('email') }}" required placeholder="you@company.com" aria-describedby="email-error" @if($errors->has('email')) aria-invalid="true" @endif><small id="email-error" class="bnc-error" data-error="email">@error('email'){{ $message }}@enderror</small></div>
                <div class="bnc-field"><label for="contact-phone">Phone <small>optional</small></label><input id="contact-phone" name="phone" type="tel" inputmode="numeric" autocomplete="tel" minlength="10" maxlength="12" pattern="[0-9]{10,12}" value="{{ old('phone') }}" placeholder="10–12 digits" aria-describedby="phone-help phone-error" @if($errors->has('phone')) aria-invalid="true" @endif><small id="phone-help" class="bnc-help">Digits only; no +, spaces or dashes.</small><small id="phone-error" class="bnc-error" data-error="phone">@error('phone'){{ $message }}@enderror</small></div>
                <div class="bnc-field"><label for="contact-subject">Subject <small>optional</small></label><input id="contact-subject" name="subject" maxlength="180" value="{{ old('subject') }}" placeholder="How can we help?" aria-describedby="subject-error" @if($errors->has('subject')) aria-invalid="true" @endif><small id="subject-error" class="bnc-error" data-error="subject">@error('subject'){{ $message }}@enderror</small></div>
                <div class="bnc-field bnc-field-full"><label for="contact-message">Your message <span aria-hidden="true">*</span></label><textarea id="contact-message" name="message" required minlength="10" maxlength="5000" rows="4" placeholder="Tell us about your requirements…" aria-describedby="message-help message-error" @if($errors->has('message')) aria-invalid="true" @endif>{{ old('message') }}</textarea><div class="bnc-help-row"><small id="message-help" class="bnc-help">10–5,000 characters</small><small class="bnc-help" data-message-count></small></div><small id="message-error" class="bnc-error" data-error="message">@error('message'){{ $message }}@enderror</small></div>
            </div>
            <div class="bnc-trap" aria-hidden="true"><label>Website<input name="website" tabindex="-1" autocomplete="off"></label></div>
            <p class="bnc-form-summary" data-form-summary role="alert" hidden>Please check the highlighted fields.</p>
            <button class="bnc-submit" type="submit" data-contact-submit><span>{{ site_setting('contact_submit_label') }}</span><span aria-hidden="true">↗</span></button>
        </form>
    </div></section>
    <section class="bnc-offices"><div class="bn2-container">
        <header class="bnc-office-heading"><div><span class="bnc-eyebrow">{{ site_setting('contact_locations_eyebrow') }}</span><h2>{{ site_setting('contact_locations_title') }}</h2></div><p>{{ site_setting('contact_locations_intro') }}</p></header>
        <div class="bnc-office-list">
            @foreach(['primary','secondary'] as $office)
            <article class="bnc-office-row">
                <div class="bnc-office-mark" aria-hidden="true"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><path d="M20 10c0 6-8 11-8 11S4 16 4 10a8 8 0 1 1 16 0Z"/><circle cx="12" cy="10" r="2.5"/></svg></div>
                <div class="bnc-office-name"><span>{{ site_setting('office_'.$office.'_name') }}</span><h3>{{ site_setting('office_'.$office.'_city') }}</h3></div>
                <p class="bnc-office-address">{{ site_setting('office_'.$office.'_address') }}</p>
                <div class="bnc-office-actions">@if(site_setting('phone_'.$office))<a href="tel:{{ preg_replace('/[^+0-9]/','',site_setting('phone_'.$office)) }}">Call office ↗</a>@endif @if(site_setting('office_'.$office.'_map'))<a href="{{ site_setting('office_'.$office.'_map') }}" target="_blank" rel="noopener noreferrer">Get directions ↗</a>@endif</div>
            </article>
            @endforeach
        </div>
    </div></section>
</div>
@endsection
