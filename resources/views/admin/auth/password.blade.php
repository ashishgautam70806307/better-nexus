@extends('layouts.admin-workspace')
@section('title','Account security')
@section('page-label','Settings')
@push('styles')<link rel="stylesheet" href="{{ asset('better-nexus/settings/settings.css') }}?v=2">@endpush
@push('scripts')<script src="{{ asset('better-nexus/settings/settings.js') }}" defer></script>@endpush
@section('workspace')
<div class="bn-settings">
<header class="bn-settings-heading"><div><span>ACCOUNT SECURITY</span><h1>Change password</h1><p>Keep your admin account secure.</p></div><a class="bn-settings-link" href="{{ route('admin.settings.edit') }}">← Website settings</a></header>
<div class="bn-password-grid"><section class="bn-settings-panel"><h2>Update your password</h2>
<form method="POST" action="{{ route('admin.password.update') }}">@csrf @method('PUT')
@foreach(['current_password'=>'Current password','password'=>'New password','password_confirmation'=>'Confirm new password'] as $key=>$label)
<div class="bn-settings-field"><label for="{{ $key }}">{{ $label }} <span>*</span></label><div class="bn-password-input"><input id="{{ $key }}" name="{{ $key }}" type="password" autocomplete="{{ $key==='current_password' ? 'current-password' : 'new-password' }}" maxlength="1024" @if($key!=='current_password') minlength="12" @endif required><button type="button" data-password-show="{{ $key }}" aria-controls="{{ $key }}" aria-pressed="false">Show</button></div>@error($key)<small class="bn-settings-invalid">{{ $message }}</small>@enderror</div>
@endforeach
<button class="bn-settings-button" type="submit">Update password</button>
</form></section><aside class="bn-password-note"><span class="bn-password-shield">✓</span><h2>A stronger password.<br>A safer account.</h2><ul><li>At least 12 characters</li><li>Uppercase and lowercase letters</li><li>At least one number and symbol</li><li>Different from your current password</li></ul><p>After saving, you’ll sign in again with your new password.</p></aside></div>
</div>
@endsection
