@extends('layouts.admin-workspace')
@section('title', 'Blogs')
@section('page-label', 'Blogs')
@include('admin.blogs.partials.assets')
@section('workspace')
<div class="bn-blog-workspace">
    <header class="bn-blog-heading">
        <div><span class="bn-blog-eyebrow">CONTENT</span><h1>Blogs</h1></div>
        <a class="btn bn-blog-primary" href="{{ route('admin.blogs.create') }}">+ Add blog</a>
    </header>
    <section class="bn-blog-card">
        <div class="bn-blog-filters">
            <div><label for="blog-status">Status</label>
                <select id="blog-status" class="form-select form-select-sm">
                    <option value="">All statuses</option><option value="draft">Draft</option>
                    <option value="published">Published</option><option value="scheduled">Scheduled</option>
                </select>
            </div>
            <div><label for="blog-category">Category</label>
                <select id="blog-category" class="form-select form-select-sm">
                    <option value="">All categories</option>
                    @foreach($categories as $category)<option value="{{ $category }}">{{ $category }}</option>@endforeach
                </select>
            </div>
            <button id="blog-reset" class="btn btn-sm btn-outline-secondary" type="button">Reset</button>
        </div>
        <p id="blog-table-error" class="alert alert-danger" role="alert" hidden>Unable to load blogs. Refresh and try again.</p>
        <table id="bn-blogs-table" class="table align-middle table-hover w-100" data-url="{{ route('admin.blogs.index') }}">
            <thead><tr><th>SR</th><th>Cover</th><th>Title</th><th>Category</th><th>Status</th><th>Updated</th><th>Actions</th></tr></thead>
            <tbody></tbody>
        </table>
    </section>
</div>
@endsection
