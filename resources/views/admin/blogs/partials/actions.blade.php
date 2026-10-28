<div class="bn-blog-actions">
    <a href="{{ route('admin.blogs.edit',$blog) }}" aria-label="Edit {{ $blog->title }}" title="Edit">
        <svg viewBox="0 0 24 24" aria-hidden="true"><path d="m16 3 5 5M4 20l4-1L21 6l-5-5L3 14l-1 8z"/></svg>
    </a>
    <form method="POST" action="{{ route('admin.blogs.destroy',$blog) }}" data-rich-delete>
        @csrf @method('DELETE')
        <button type="submit" aria-label="Delete {{ $blog->title }}" title="Delete"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M3 6h18M9 6V3h6v3M5 6l1 15h12l1-15M10 10v7M14 10v7"/></svg></button>
    </form>
</div>
