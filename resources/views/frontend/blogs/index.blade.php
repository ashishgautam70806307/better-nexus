@extends('layouts.frontend')
@section('title','Insights & Articles | '.site_setting('website_name'))
@section('description', 'Insights on virtual assistance, delegation, customer support, marketing operations, and more from Better Nexus.')
@section('content')
<div class="bn-experience-blog-index">
    <header class="bn-journal-heading"><div class="va-wrap">
        <nav class="va-crumb" aria-label="Breadcrumb"><a href="{{ route('home') }}">Home</a><span aria-hidden="true">/</span><span>Blogs</span></nav>
        <div class="va-split va-blog-lead">
            <div><span class="va-kicker">THE BETTER NEXUS JOURNAL</span><h1>Useful ideas for a more focused workday.</h1>
                <p>Discover practical articles on virtual assistant support, delegation, and running your business with greater clarity.</p>
                <span class="bn-journal-count">{{ $blogs->total() }} {{ $blogs->total() === 1 ? 'article' : 'articles' }} available</span>
            </div>
            <img class="va-journal-art" src="{{ asset('better-nexus/assets/images/editorial/office-3184360.jpg') }}" width="900" height="560" alt="" decoding="async" fetchpriority="high">
        </div>
    </div></header>
    <section class="va-section bn-experience-blog-listing" aria-labelledby="bn-blog-listing-heading"><div class="va-wrap">
        <div class="bn-experience-blog-toolbar">
            <div><span class="va-kicker">EXPLORE INSIGHTS</span><h2 id="bn-blog-listing-heading">Latest articles</h2></div>
            <form method="GET" action="{{ route('blogs.index') }}" role="search" class="bn-experience-search">
                <label class="visually-hidden" for="bn-blog-search">Search articles</label>
                <input id="bn-blog-search" type="search" name="search" maxlength="100" value="{{ $search }}" placeholder="Search by topic or title…">
                <button type="submit">Search <span aria-hidden="true">↗</span></button>
            </form>
        </div>
        @if($blogs->isNotEmpty())
            <div class="bn-experience-blog-grid" data-bn-reveal-grid>
                @foreach($blogs as $blog)
                    <x-frontend.blog-card :blog="$blog" />
                @endforeach
            </div>
            <div class="bn-experience-pagination">{{ $blogs->links('components.blog-pagination') }}</div>
        @else
            <div class="bn-experience-blog-empty"><h3>No matching articles found</h3><p>Try a different search term or explore all published articles.</p>
                <a class="va-button" href="{{ route('blogs.index') }}">View all articles ↗</a></div>
        @endif
    </div></section>
</div>
@endsection
