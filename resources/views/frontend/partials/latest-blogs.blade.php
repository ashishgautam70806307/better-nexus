@push('styles')
    <link rel="stylesheet" href="{{ asset('better-nexus/blogs/module.css') }}">
@endpush
@php($latestBlogs = \App\Models\Blog::published()->latest('published_at')->limit(3)->get())
@if ($latestBlogs->isNotEmpty())
    <section class="container py-5">
        <div class="d-flex flex-wrap justify-content-between gap-3 mb-4">
            <div><span class="bn-story-tag">IDEAS INTO IMPACT</span>
                <h2>Stories worth sharing.</h2>
            </div><a href="{{ route('blogs.index') }}">Explore all stories ↗</a>
        </div>
        <div class="row g-4">
            @foreach ($latestBlogs as $blog)
                <div class="col-md-6 col-lg-4"><x-frontend.blog-card :blog="$blog" />oooooooooooooooooooooooooooooooo</div>
            @endforeach
        </div>
    </section>
@endif
