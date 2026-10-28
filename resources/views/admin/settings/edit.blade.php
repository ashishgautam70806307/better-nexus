@extends('layouts.admin-workspace')
@section('title','Website settings')
@section('page-label','Settings')
@push('styles')<link rel="stylesheet" href="{{ asset('better-nexus/settings/settings.css') }}?v=2">@endpush
@push('scripts')<script src="{{ asset('better-nexus/settings/settings.js') }}" defer></script>@endpush
@section('workspace')
<div class="bn-settings">
    <header class="bn-settings-heading"><div><span>WEBSITE MANAGEMENT</span><h1>Website settings</h1><p>Your brand, contact information and social profiles.</p></div><a class="bn-settings-link" href="{{ route('admin.password.edit') }}">Change password ↗</a></header>
    <nav class="bn-settings-nav" aria-label="Settings sections"><a href="#branding">Branding</a>@foreach($groups as $group=>$fields)<a href="#settings-{{ $group }}">{{ ucfirst($group) }}</a>@endforeach</nav>
    @if($errors->any())<div class="bn-settings-errors" role="alert"><strong>Please correct the highlighted details.</strong><ul>@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>@endif
    <form method="POST" action="{{ route('admin.settings.update') }}" enctype="multipart/form-data">
        @csrf @method('PUT')
        <section class="bn-settings-panel" id="branding"><div class="bn-settings-section"><span>01</span><div><h2>Brand assets</h2><p>PNG, JPG or WebP logos up to 2 MB. Square PNG favicon, 32–512 px, up to 512 KB.</p></div></div>
            <div class="bn-settings-assets">
            @foreach(['header_logo'=>'Header logo','footer_logo'=>'Footer logo','favicon'=>'Favicon'] as $key=>$label)
                <div class="bn-settings-upload" data-upload-box><label for="{{ $key }}">{{ $label }}</label>
                    <div class="bn-settings-image">@if(site_asset($key))<img src="{{ site_asset($key) }}" alt="Current {{ $label }}" data-image-preview>@else<img data-image-preview hidden alt="Selected {{ $label }}"><span>Upload {{ strtolower($label) }}</span>@endif</div>
                    <input type="file" id="{{ $key }}" name="{{ $key }}" accept="{{ $key==='favicon' ? 'image/png' : 'image/png,image/jpeg,image/webp' }}" data-image-input>
                    @if(site_asset($key))<label class="bn-settings-checkbox"><input type="checkbox" name="remove_{{ $key }}" value="1" @checked(old('remove_'.$key))>Remove on save</label>@endif
                    @error($key)<small class="bn-settings-invalid">{{ $message }}</small>@enderror
                </div>
            @endforeach
            </div>
        </section>
        @foreach($groups as $group=>$fields)
        <section class="bn-settings-panel" id="settings-{{ $group }}"><div class="bn-settings-section"><span>{{ str_pad($loop->iteration+1,2,'0',STR_PAD_LEFT) }}</span><div><h2>{{ ucfirst($group) }} details</h2><p>{{ $group==='contact' ? 'Shown on the public contact page and footer.' : 'Keep these details accurate and up to date.' }}</p></div></div>
            <div class="bn-settings-fields">
            @foreach($fields as $key=>$definition)
                <div class="bn-settings-field"><label for="{{ $key }}">{{ $definition[0] }} @if($key==='website_name')<span>*</span>@endif</label>
                @if(str_contains($key,'address') || in_array($key,['contact_intro','meta_description']))
                    <textarea id="{{ $key }}" name="{{ $key }}" rows="3" maxlength="1000">{{ old($key,site_setting($key)) }}</textarea>
                @else
                    <input id="{{ $key }}" name="{{ $key }}" type="{{ str_contains($key,'email') ? 'email' : (in_array($key,['website_url','office_primary_map','office_secondary_map','facebook','instagram','linkedin','youtube','x_url']) ? 'url' : 'text') }}" maxlength="1000" value="{{ old($key,site_setting($key)) }}" @required($key==='website_name')>
                @endif
                @error($key)<small class="bn-settings-invalid">{{ $message }}</small>@enderror</div>
            @endforeach
            </div>
        </section>
        @endforeach
        <div class="bn-settings-save"><p>Changes appear across the website after saving.</p><button class="bn-settings-button" type="submit">Save settings</button></div>
    </form>
</div>
@endsection
