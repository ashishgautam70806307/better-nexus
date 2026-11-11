@extends('layouts.frontend')
@section('title', ($blog->meta_title ?: $blog->title) . ' | ' . site_setting('website_name'))
@section('description', $blog->meta_description ?: \App\Support\BlogText::plain($blog->excerpt))
@push('styles')
    <link rel="canonical" href="{{ route('blogs.show', ['slug' => $blog->slug]) }}">
    <meta property="og:title" content="{{ $blog->meta_title ?: $blog->title }}">
    <meta property="og:description" content="{{ $blog->meta_description ?: \App\Support\BlogText::plain($blog->excerpt) }}">
    <meta property="og:image" content="{{ $blog->display_image_url }}">
    <link rel="stylesheet" href="{{ asset('better-nexus/blogs/rich/article.css') }}">
@endpush
@section('content')
<article class="bn-story-page bn-experience-story">
    <div class="va-wrap">
        <nav class="bn-story-crumb va-crumb" aria-label="Breadcrumb">
            <a href="{{ route('home') }}">Home</a><span aria-hidden="true">/</span>
            <a href="{{ route('blogs.index') }}">Blogs</a><span aria-hidden="true">/</span><span aria-current="page">Article</span>
        </nav>
        <header class="bn-story-heading">
            <span class="bn-experience-article-label">{{ $blog->category ?: 'Insights' }}</span>
            <h1>{{ $blog->title }}</h1>
            <div class="bn-story-byline">
                <span>By {{ $blog->author_name ?: site_setting('website_name') }}</span>
                @if($blog->published_at)<time datetime="{{ $blog->published_at->toDateString() }}">{{ $blog->published_at->format('d M Y') }}</time>@endif
                <span>{{ max(1, (int) ceil(str_word_count(\App\Support\BlogText::plain($blog->content)) / 200)) }} min read</span>
            </div>
        </header>
        <div class="bn-experience-story-cover"><img class="bn-story-main-cover" src="{{ $blog->display_image_url }}" alt="" width="1440" height="820" fetchpriority="high"></div>
        <div class="bn-story-body">
            <div class="bn-experience-story-main">
                @if(\App\Support\BlogText::plain($blog->excerpt))<div class="bn-story-lead bn-rich-output">{!! \App\Support\BlogText::html($blog->excerpt) !!}</div>@endif
                <div class="bn-story-copy bn-rich-output">{!! \App\Support\BlogText::html($blog->content) !!}</div>
                <a class="bn-story-back" href="{{ route('blogs.index') }}">← Back to all articles</a>
            </div>
            <aside class="bn-story-support">
                <span>VIRTUAL ASSISTANT SERVICES</span><h2>More time for the work that matters.</h2>
                <p>Tell us which recurring tasks are slowing you down. We'll help you explore a practical handoff.</p>
                <a href="{{ route('contact-us') }}#bn-contact-live">Talk to our team ↗</a>
            </aside>
        </div>
        @if($related->isNotEmpty())
            <section class="bn-related" aria-labelledby="bn-related-heading">
                <div class="bn-experience-section-intro"><div><span class="va-kicker">KEEP EXPLORING</span><h2 id="bn-related-heading">More articles you may like</h2></div>
                    <a href="{{ route('blogs.index') }}" class="va-card-link">View all articles ↗</a></div>
                <div class="bn-experience-blog-grid">@foreach($related as $item)<x-frontend.blog-card :blog="$item" />@endforeach</div>
            </section>
        @endif
    </div>
</article>
@endsection
