@extends('layouts.frontend')
@section('title', site_setting('meta_title') ?: site_setting('website_name'))
@section('description', site_setting('meta_description'))
@section('body-class', 'bn-approved-home')

@push('styles')
<link rel="stylesheet" href="{{ asset('better-nexus/approved/home.css') }}?v=20261029d">
<link rel="preload" as="image" href="{{ asset('better-nexus/approved/team-poster.webp') }}">
@endpush
@push('scripts')
<script src="{{ asset('better-nexus/approved/home.js') }}?v=20261029d" defer></script>
@endpush
@section('content')
@include('frontend.sections.home.hero')
@include('frontend.sections.home.ribbon')
@include('frontend.sections.home.right-connection')
@include('frontend.sections.home.services')
@include('frontend.sections.home.photo-depth')
@include('frontend.sections.home.process')
@include('frontend.sections.home.blogs')
@include('frontend.sections.home.benefits')
@include('frontend.sections.home.expertise')
@endsection
