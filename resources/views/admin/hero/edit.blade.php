@extends('layouts.admin-workspace')
@section('title','Responsive homepage hero videos')
@section('page-label','Homepage hero')
@push('styles')<link rel="stylesheet" href="{{ asset('better-nexus/hero/admin.css') }}?v=2"><link rel="stylesheet" href="{{ asset('better-nexus/hero/responsive-video-admin.css') }}?v=1"><link rel="stylesheet" href="{{ asset('better-nexus/hero/upload-progress.css') }}?v=20261111a">@endpush
@push('scripts')<script src="{{ asset('better-nexus/hero/upload-progress.js') }}?v=20261111a" defer></script>@endpush
@section('workspace')
<div class="bn-hero-admin bn-hero-videos">
  <header class="bha-heading"><div><span>HOMEPAGE MANAGEMENT</span><h1>Hero video studio</h1><p>Upload a separate video for desktop and mobile. Preview each one, then control what goes live.</p></div><a href="{{ route('home') }}" target="_blank" rel="noopener noreferrer">View live homepage ↗</a></header>
  @if($errors->any())<div class="bha-errors" role="alert"><strong>Check these fields:</strong><ul>@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>@endif
  @if(session('success'))<p class="bha-success" role="status">{{ session('success') }}</p>@endif
  <div class="bha-live-notice" role="status" aria-live="polite" data-global-notice hidden></div>
  <div class="bha-video-grid">
    @foreach(['desktop'=>'Desktop / Laptop (16:9)','mobile'=>'Mobile (9:16)'] as $device=>$label)
      @php($path=$hero->{$device.'_video_path'})
      <section class="bha-panel bha-video-slot" data-video-slot="{{ $device }}"><div class="bha-section-title"><span>{{ $device==='desktop'?'01':'02' }}</span><div><h2>{{ $label }}</h2><p>{{ $device==='desktop'?'Recommended 1920×1080 or 1280×720':'Recommended 1080×1920 or 720×1280' }} · MP4 H.264, silent loop preferred</p></div></div>
       <div data-video-preview class="bha-preview {{ $device==='mobile'?'bha-preview-mobile':'' }}">
        @if($path)
          <video controls muted loop playsinline preload="metadata" src="{{ route('admin.hero-video.preview',['device'=>$device,'v'=>pathinfo($path,PATHINFO_FILENAME)]) }}" aria-label="{{ $label }} preview"></video>
        @else
          <p>No video uploaded yet. Upload a video to preview it here.</p>
        @endif
       </div>
       <span data-video-state class="bha-state {{ $hero->{$device.'_video_published'}?'is-live':'is-draft' }}">{{ $path ? ($hero->{$device.'_video_published'}?'Published':'Draft / hidden') : 'Empty slot' }}</span>
       <form method="POST" action="{{ route('admin.hero-video.update') }}" enctype="multipart/form-data" class="bha-video-form" data-ajax-video>@csrf @method('PUT')
        <input type="hidden" name="device" value="{{ $device }}">
        <label>Upload {{ $device }} video <input type="file" name="video" accept="video/mp4,video/webm,.mp4,.webm" required></label>
        <small>Up to 100 MB. "Upload &amp; Publish Now" replaces the live video for this device immediately. "Upload as Draft" keeps it hidden until published.</small>
        <div class="bha-upload-progress" data-upload-progress hidden>
          <div class="bha-progress-top"><strong data-progress-label>Uploading...</strong><span data-progress-percent>0%</span></div>
          <progress data-progress-bar max="100" value="0" aria-label="Video upload progress">0%</progress>
          <p data-progress-detail>Sending video to the server</p>
          <button type="button" class="bha-upload-cancel" data-upload-cancel>Cancel upload</button>
        </div>
        <p class="bha-form-feedback" data-upload-feedback role="status" aria-live="polite"></p>
        <div class="bha-upload-actions"><button class="bha-save" type="submit" name="publication" value="publish">Upload &amp; Publish Now</button><button class="bha-save bha-save-draft" type="submit" name="publication" value="draft">Upload as Draft</button></div>
       </form>
       @if($path)<form method="POST" action="{{ route('admin.hero-video.destroy') }}" onsubmit="return confirm('Remove {{ $device }} video?')">@csrf @method('DELETE')<input type="hidden" name="device" value="{{ $device }}"><button class="bha-delete" type="submit">Remove {{ $device }} video</button></form>@endif
      </section>
    @endforeach
  </div>
  <section class="bha-panel bha-publish"><div class="bha-section-title"><span>03</span><div><h2>Publish controls</h2><p>Use these switches to publish existing drafts or unpublish a device. Upload &amp; Publish Now works immediately without this extra step.</p></div></div>
   <form method="POST" action="{{ route('admin.hero-video.publish') }}" data-ajax-publish>@csrf @method('PUT')
    <label class="bha-check"><input type="checkbox" name="is_active" value="1" @checked(old('is_active',$hero->is_active))> Enable video on homepage</label>
    <label class="bha-check"><input type="checkbox" name="desktop_video_published" value="1" @checked(old('desktop_video_published',$hero->desktop_video_published)) @disabled(!$hero->desktop_video_path)> Publish desktop video</label>
    <label class="bha-check"><input type="checkbox" name="mobile_video_published" value="1" @checked(old('mobile_video_published',$hero->mobile_video_published)) @disabled(!$hero->mobile_video_path)> Publish mobile video</label>
    <button class="bha-save" type="submit">Save publication settings</button>
    <p class="bha-form-feedback" role="status" aria-live="polite" data-publish-feedback></p>
   </form>
  </section>
</div>
@endsection
