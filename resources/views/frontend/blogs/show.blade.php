@extends('layouts.frontend')
@section('title', ($blog->meta_title ?: $blog->title) . ' | ' . site_setting('website_name'))
@section('description', $blog->meta_description ?: \App\Support\BlogText::plain($blog->excerpt))
@push('styles')
<link rel="stylesheet" href="{{ asset('better-nexus/blogs/read-more.css') }}?v=1">
    <link rel="canonical" href="{{ route('blogs.show', ['slug' => $blog->slug]) }}">
    <meta property="og:title" content="{{ $blog->meta_title ?: $blog->title }}">
    <meta property="og:description" content="{{ $blog->meta_description ?: \App\Support\BlogText::plain($blog->excerpt) }}">
    @if ($blog->image_url)
        <meta property="og:image" content="{{ $blog->image_url }}">
    @endif
    <link rel="stylesheet" href="{{ asset('better-nexus/hero/module.css') }}?v=1">
    <link rel="stylesheet" href="{{ asset('better-nexus/blogs/rich/article.css') }}">
@endpush
@section('content')
    <article class="bn-story-page">
        <div class="bn2-container">
            <nav class="bn-story-crumb" aria-label="Breadcrumb"><a href="{{ route('home') }}">Home</a><span
                    aria-hidden="true">/</span><a href="{{ route('blogs.index') }}">Blogs</a><span
                    aria-hidden="true">/</span><span>Blog</span></nav>
            <header class="bn-story-heading"><span>{{ $blog->category ?: 'Insights' }}</span>
                <h1>{{ $blog->title }}</h1>
                <div class="bn-story-byline"><span>{{ $blog->author_name ?: site_setting('website_name') }}</span><time
                        datetime="{{ $blog->published_at?->toIso8601String() }}">{{ $blog->published_at?->format('d M Y') }}</time><span>{{ max(1, (int) ceil(str_word_count(\App\Support\BlogText::plain($blog->content)) / 200)) }}
                        min read</span></div>
            </header>
            @if ($blog->image_url)
                <img class="bn-story-main-cover" src="{{ $blog->image_url }}" alt="{{ $blog->title }}" width="1200"
                    height="650" fetchpriority="high">
            @endif
            <div class="bn-story-body">
                <div>
                    <div class="bn-story-lead bn-rich-output">{!! \App\Support\BlogText::html($blog->excerpt) !!}</div>
                    <div class="bn-story-copy bn-rich-output">{!! \App\Support\BlogText::html($blog->content) !!}</div><a class="bn-story-back"
                        href="{{ route('blogs.index') }}">← Back to all blogs</a>
                </div>
                <aside class="bn-story-support"><span>LET’S CONNECT</span>
                    <h2>Turn ideas into progress.</h2>
                    <p>{{ site_setting('tagline') }}</p><a href="{{ route('contact-us') }}">Talk to our team ↗</a>
                    @if (site_setting('contact_email'))
                        <small>{{ site_setting('contact_email') }}</small>
                    @endif
                </aside>
            </div>
            @if ($related->isNotEmpty())
                <section class="bn-related">
                    <h2>Keep exploring.</h2>
                    <div class="bn-home-blog-grid">
                        @foreach ($related as $item)
                            <x-frontend.blog-card :blog="$item" />
                        @endforeach
                    </div>
                </section>
            @endif
        </div>
    </article>
@endsection
