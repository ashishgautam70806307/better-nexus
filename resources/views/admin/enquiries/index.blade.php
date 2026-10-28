@extends('layouts.admin-workspace')
@section('title','Contact enquiries')
@section('page-label','Contact enquiries')
@push('styles')<link rel="stylesheet" href="{{ asset('better-nexus/enquiries/admin.css') }}">@endpush
@section('workspace')
<div class="bn-enquiries">
    <header><div><h1>Contact enquiries</h1><p>{{ $enquiries->total() }} matching enquiries</p></div></header>
    <section class="bn-enquiry-card">
        <form method="GET" class="bn-enquiry-filters">
            <input name="search" aria-label="Search enquiries" placeholder="Search name, email, phone or subject" value="{{ $search }}" maxlength="100">
            <select name="status" aria-label="Filter status"><option value="">All statuses</option>@foreach(\App\Models\ContactEnquiry::STATUSES as $key=>$label)<option value="{{ $key }}" @selected(request('status')===$key)>{{ $label }}</option>@endforeach</select>
            <button type="submit">Apply</button><a href="{{ route('admin.enquiries.index') }}">Reset</a>
        </form>
        <div class="bn-enquiry-scroll"><table><thead><tr><th>SR</th><th>Contact</th><th>Subject</th><th>Status</th><th>Received</th><th>Actions</th></tr></thead><tbody>
            @forelse($enquiries as $enquiry)
                <tr><td>{{ $enquiries->firstItem()+$loop->index }}</td><td><strong>{{ $enquiry->name }}</strong><small>{{ $enquiry->email }}</small></td><td>{{ \Illuminate\Support\Str::limit($enquiry->subject ?: 'General enquiry',50) }}</td><td><span class="bn-enquiry-badge">{{ \App\Models\ContactEnquiry::STATUSES[$enquiry->status] ?? $enquiry->status }}</span></td><td>{{ $enquiry->created_at->format('d M Y') }}</td><td><div class="bn-enquiry-actions"><a href="{{ route('admin.enquiries.show',$enquiry) }}">Manage</a><form method="POST" action="{{ route('admin.enquiries.destroy',$enquiry) }}" data-enquiry-delete>@csrf @method('DELETE')<button type="submit" class="is-danger" aria-label="Delete enquiry from {{ $enquiry->name }}">Delete</button></form></div></td></tr>
            @empty<tr><td colspan="6">No enquiries found.</td></tr>@endforelse
        </tbody></table></div>
        <nav class="bn-enquiry-pagination" aria-label="Enquiry pages"><span>{{ $enquiries->firstItem() ?? 0 }}–{{ $enquiries->lastItem() ?? 0 }} of {{ $enquiries->total() }}</span><div>@if($enquiries->previousPageUrl())<a href="{{ $enquiries->previousPageUrl() }}">← Previous</a>@endif<span>Page {{ $enquiries->currentPage() }} / {{ $enquiries->lastPage() }}</span>@if($enquiries->nextPageUrl())<a href="{{ $enquiries->nextPageUrl() }}">Next →</a>@endif</div></nav>
    </section>
</div>
@endsection
