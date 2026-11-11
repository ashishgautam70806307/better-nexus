<section class="va-section" id="va-blogs" aria-labelledby="va-blog-heading"><div class="va-wrap">
    <div class="va-blog-heading">
        <div><span class="va-kicker">FROM THE BLOG</span><h2 id="va-blog-heading">Practical reads for your next handoff</h2></div>
        <a class="va-card-link" href="{{ route('blogs.index') }}">Browse all articles <span aria-hidden="true">↗</span></a>
    </div>
    @if($latestBlogs->isNotEmpty())
        <div class="va-cards">@foreach($latestBlogs as $blog)<x-frontend.blog-card :blog="$blog" />@endforeach</div>
    @else
        <p class="va-blog-empty">No articles have been published yet. Check back for practical guides and ideas.</p>
    @endif
</div></section>
