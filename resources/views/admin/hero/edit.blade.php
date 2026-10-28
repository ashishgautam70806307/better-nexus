@extends('layouts.admin-workspace')
@section('title','Homepage hero')
@section('page-label','Home hero banner')
@push('styles')<link rel="stylesheet" href="{{ asset('better-nexus/hero/admin.css') }}?v=1">@endpush
@push('scripts')<script src="{{ asset('better-nexus/hero/admin.js') }}?v=1" defer></script>@endpush
@section('workspace')
<div class="bn-hero-admin">
    <header class="bha-heading"><div><span>HOMEPAGE MANAGEMENT</span><h1>Home hero</h1><p>Shape the first impression. Keep your message clear.</p></div><a href="{{ route('home') }}" target="_blank" rel="noopener noreferrer">Open homepage ↗</a></header>
    @if($errors->any())<div class="bha-errors" role="alert"><strong>Please check your details.</strong><ul>@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>@endif
    <form method="POST" action="{{ route('admin.hero-banners.update') }}" enctype="multipart/form-data" class="bha-grid">
        @csrf @method('PUT')
        <section class="bha-panel"><div class="bha-section-title"><span>01</span><div><h2>Hero content</h2><p>Text is displayed safely as plain text.</p></div></div>
            <div class="bha-fields">
                <label class="bha-wide">Small heading<input name="eyebrow" maxlength="150" value="{{ old('eyebrow',$hero->eyebrow) }}" placeholder="GREAT PEOPLE. MEANINGFUL CONNECTIONS."></label>
                <label>Main title <span>*</span><input name="title" required maxlength="180" value="{{ old('title',$hero->title) }}" placeholder="Great talent."></label>
                <label>Highlighted line<input name="highlight" maxlength="180" value="{{ old('highlight',$hero->highlight) }}" placeholder="Better possibilities."></label>
                <label class="bha-wide">Description<textarea name="description" maxlength="1500" rows="3">{{ old('description',$hero->description) }}</textarea></label>
            </div>
            <h3>Action buttons</h3><div class="bha-fields">
                <label>Primary button text<input name="primary_label" maxlength="70" value="{{ old('primary_label',$hero->primary_label) }}"></label>
                <label>Primary destination<input name="primary_url" maxlength="1000" value="{{ old('primary_url',$hero->primary_url) }}" placeholder="/services"></label>
                <label>Secondary button text<input name="secondary_label" maxlength="70" value="{{ old('secondary_label',$hero->secondary_label) }}"></label>
                <label>Secondary destination<input name="secondary_url" maxlength="1000" value="{{ old('secondary_url',$hero->secondary_url) }}" placeholder="/contact-us"></label>
            </div><p class="bha-hint">Use /page paths or HTTPS links. Leave both fields blank to hide a button.</p>
        </section>
        <aside class="bha-panel"><div class="bha-section-title"><span>02</span><div><h2>Publish &amp; images</h2><p>Add several together or one at a time.</p></div></div>
            <label class="bha-check"><input type="checkbox" name="is_active" value="1" @checked(old('is_active',$hero->is_active))>Show hero on homepage</label>
            <label class="bha-check"><input type="checkbox" name="show_video" value="1" @checked(old('show_video',$hero->show_video))>Enable existing background video</label>
            <p class="bha-hint">Video plays only when visitors choose Play; reduced-motion preference is respected.</p>
            <div class="bha-upload"><span class="bha-upload-icon" aria-hidden="true">↥</span><strong>Add hero images</strong><span>JPG, PNG or WebP · up to 4 MB each<br>100–6000 px · maximum 8 per upload</span><input type="file" name="images[]" multiple accept="image/jpeg,image/png,image/webp" data-hero-files></div>
            <p class="bha-hint">{{ $hero->images->count() }} / 16 gallery slots used. Additions append to your existing list.</p><div class="bha-selected" data-hero-preview></div>
            <button type="submit" class="bha-save">Save hero changes</button>
        </aside>
    </form>
    <section class="bha-panel bha-gallery"><div class="bha-gallery-head"><div><h2>Image library <small>{{ $hero->images->count() }}</small></h2><p>Lower order appears first. Each card saves independently.</p></div></div>
        <div class="bha-image-grid">
            @forelse($hero->images as $image)
                <article class="bha-image-card"><div class="bha-image-cover"><img src="{{ asset($image->path) }}" alt="{{ $image->alt }}" width="320" height="180" loading="lazy"><span>{{ $image->is_active ? 'Visible':'Hidden' }}</span></div>
                    <form method="POST" action="{{ route('admin.hero-images.update',$image) }}" enctype="multipart/form-data" class="bha-image-form">@csrf @method('PUT')<input type="hidden" name="_image_id" value="{{ $image->id }}">
                        <label>Image description / alt text<input name="alt" maxlength="180" value="{{ (string)old('_image_id')===(string)$image->id ? old('alt',$image->alt) : $image->alt }}" placeholder="Describe the person or scene"></label>
                        <div class="bha-image-options"><label>Order<input name="sort_order" type="number" min="0" max="9999" value="{{ $image->sort_order }}" required></label><label class="bha-check"><input type="checkbox" name="is_active" value="1" @checked($image->is_active)>Visible</label></div>
                        <label>Replace image <small>optional</small><input type="file" name="image" accept="image/jpeg,image/png,image/webp"></label>
                        <button type="submit" class="bha-save bha-save-light">Save image</button>
                    </form>
                    <form method="POST" action="{{ route('admin.hero-images.destroy',$image) }}" data-hero-delete>@csrf @method('DELETE')<button class="bha-delete" type="submit" aria-label="Remove hero image {{ $image->id }}">Remove image</button></form>
                </article>
            @empty<div class="bha-empty"><h3>No hero images yet.</h3><p>Add your first image using the upload area above. Your hero text can still be published.</p></div>@endforelse
        </div>
    </section>
</div>
@endsection
