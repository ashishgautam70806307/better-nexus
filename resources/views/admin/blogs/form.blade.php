@extends('layouts.admin-workspace')
@section('page-label','Blogs')
@include('admin.blogs.partials.assets')
@section('title',$blog->exists ? 'Edit blog' : 'New blog')
@section('workspace')<div class="bw">
<header class="bw-head">
<div>
<a href="{{ route('admin.blogs.index') }}">← Blogs</a>
<h1>{{ $blog->exists ? 'Edit blog' : 'New blog' }}</h1>
</div>
<a class="bw-btn bw-light" href="{{ route('admin.blogs.index') }}">Cancel</a>
</header>
@if($errors->any())<div class="bw-error" role="alert">
<strong>Please correct the following:</strong>
<ul>@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
</div>@endif
<form data-rich-form method="POST" enctype="multipart/form-data" action="{{ $blog->exists ? route('admin.blogs.update',$blog) : route('admin.blogs.store') }}">@csrf @if($blog->exists) @method('PUT') @endif
<input type="hidden" name="slug" value="{{ $blog->slug }}">
<div class="bw-grid">
<section class="bw-panel">
<h2>Blog content</h2>
<label for="title">Title <span>*</span>
</label>
<input id="title" name="title" maxlength="255" value="{{ old('title',$blog->title) }}" required placeholder="Enter your blog title">
<small class="bw-help">The URL is created automatically. Existing URLs stay unchanged when editing.</small>
<label for="excerpt">Short description <small>optional</small>
</label>
<div class="bn-rich-field" data-rich-field>
    <textarea id="excerpt" name="excerpt" data-rich-input rows="5">{{ old('excerpt', \App\Support\BlogText::html($blog->excerpt)) }}</textarea>
    <div data-rich-editor hidden>
</div>
    <small data-word-count class="bw-help">
</small>
</div>
<label for="content">Full description <span>*</span>
</label>
<div class="bn-rich-field bn-rich-full" data-rich-field>
    <textarea id="content" name="content" data-rich-input rows="16">{{ old('content', \App\Support\BlogText::html($blog->content)) }}</textarea>
    <div data-rich-editor hidden>
</div>
    <small data-word-count class="bw-help">
</small>
</div>
<p id="rich-error" class="bw-error" role="alert" hidden>
</p>
</section>
<aside>
<section class="bw-panel">
<h2>Publish</h2>
<label for="status">Status</label>
<select name="is_published" id="status">
<option value="0" @selected(!old('is_published',$blog->is_published))>Draft</option>
<option value="1" @selected(old('is_published',$blog->is_published))>Published</option>
</select>
<label for="published_at">Publish date <small>optional</small>
</label>
<input type="datetime-local" name="published_at" id="published_at" value="{{ old('published_at',$blog->published_at?->format('Y-m-d\TH:i')) }}">
<small class="bw-help">Leave blank to publish now. A future date schedules the blog.</small>
<button class="bw-btn bw-save" type="submit">{{ $blog->exists ? 'Save changes' : 'Create blog' }}</button>
</section>
<section class="bw-panel">
<h2>Cover image</h2>
<div data-image-box>@if($blog->image_url)<img class="bw-cover" data-image-preview src="{{ $blog->image_url }}" alt="Current cover">@else<img class="bw-cover" data-image-preview hidden alt="Selected cover">@endif<label for="image">Upload or replace</label>
<input type="file" id="image" name="image" accept="image/jpeg,image/png,image/webp" data-image-input>
<small class="bw-help">JPG, PNG or WebP · up to 4 MB · max 6000 × 6000 px</small>
<p data-image-error class="bw-error" hidden>
</p>@if($blog->image_url)<label class="bw-checkbox">
<input type="checkbox" name="remove_image" value="1" @checked(old('remove_image'))> Remove current image on save</label>@endif</div>
</section>
<details class="bw-panel">
<summary>Additional details <small>optional</small>
</summary>
<label for="category">Category</label>
<input id="category" name="category" value="{{ old('category',$blog->category) }}">
<label for="author_name">Author</label>
<input id="author_name" name="author_name" value="{{ old('author_name',$blog->author_name) }}">
<label for="meta_title">SEO title</label>
<input id="meta_title" name="meta_title" value="{{ old('meta_title',$blog->meta_title) }}">
<label for="meta_description">SEO description</label>
<input id="meta_description" name="meta_description" value="{{ old('meta_description',$blog->meta_description) }}">
</details>
</aside>
</div>
</form>
</div>@endsection