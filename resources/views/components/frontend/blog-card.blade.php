@props(['blog'])
<article class="bn-journal-card bn-experience-blog-card bn-reveal">
    <a class="bn-journal-cover" href="{{ route('blogs.show', ['slug' => $blog->slug]) }}" aria-label="Read {{ $blog->title }}">
        <img src="{{ $blog->display_image_url }}" alt="" width="720" height="450" loading="lazy" decoding="async">
        <span class="bn-experience-cover-corner" aria-hidden="true">↗</span>
    </a>
    <div class="bn-journal-card-copy">
        <div class="bn-journal-meta">
            <span>{{ $blog->category ?: 'Insights' }}</span>
            @if($blog->published_at)<time datetime="{{ $blog->published_at->toDateString() }}">{{ $blog->published_at->format('d M Y') }}</time>@endif
        </div>
        <h3><a href="{{ route('blogs.show', ['slug' => $blog->slug]) }}">{{ $blog->title }}</a></h3>
        <p>{{ \Illuminate\Support\Str::limit(\App\Support\BlogText::plain($blog->excerpt ?: $blog->content), 145) }}</p>
        <a class="bn-journal-read" href="{{ route('blogs.show', ['slug' => $blog->slug]) }}">Read More <span aria-hidden="true">↗</span></a>
    </div>
</article>
