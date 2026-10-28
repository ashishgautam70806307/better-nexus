@if($blog->image_url)
<img src="{{ $blog->image_url }}" width="60" height="44" class="bn-blog-thumb" alt="" loading="lazy">
@else<span class="bn-blog-noimage" aria-label="No cover image">—</span>@endif
