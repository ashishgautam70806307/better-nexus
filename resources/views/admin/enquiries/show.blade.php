@extends('layouts.admin-workspace')
@section('title','Manage enquiry')
@section('page-label','Contact enquiries')
@push('styles')<link rel="stylesheet" href="{{ asset('better-nexus/enquiries/admin.css') }}">@endpush
@section('workspace')
<div class="bn-enquiries">
    <header><div><a href="{{ route('admin.enquiries.index') }}">← All enquiries</a><h1>Enquiry #{{ $enquiry->id }}</h1><p>{{ $enquiry->created_at->format('d M Y, h:i A') }}</p></div></header>
    <div class="bn-enquiry-grid">
        <article class="bn-enquiry-card"><h2>{{ $enquiry->subject ?: 'General enquiry' }}</h2><dl><dt>Name</dt><dd>{{ $enquiry->name }}</dd><dt>Email</dt><dd>{{ $enquiry->email }}</dd><dt>Phone</dt><dd>{{ $enquiry->phone ?: 'Not provided' }}</dd></dl><h3>Message</h3><p class="bn-enquiry-message">{{ $enquiry->message }}</p></article>
        <aside class="bn-enquiry-card"><h2>Manage enquiry</h2><form method="POST" action="{{ route('admin.enquiries.update',$enquiry) }}">@csrf @method('PUT')
            <label for="enquiry-status">Status</label><select id="enquiry-status" name="status">@foreach(\App\Models\ContactEnquiry::STATUSES as $key=>$label)<option value="{{ $key }}" @selected(old('status',$enquiry->status)===$key)>{{ $label }}</option>@endforeach</select>@error('status')<small role="alert">{{ $message }}</small>@enderror
            <label for="enquiry-notes">Internal notes <small>optional</small></label><textarea id="enquiry-notes" name="admin_notes" rows="7" maxlength="5000">{{ old('admin_notes',$enquiry->admin_notes) }}</textarea>@error('admin_notes')<small role="alert">{{ $message }}</small>@enderror
            <button type="submit">Save changes</button>
        </form><form method="POST" action="{{ route('admin.enquiries.destroy',$enquiry) }}" data-enquiry-delete style="margin-top:16px">@csrf @method('DELETE')<button class="is-danger" type="submit">Delete enquiry</button></form></aside>
    </div>
</div>
@endsection
