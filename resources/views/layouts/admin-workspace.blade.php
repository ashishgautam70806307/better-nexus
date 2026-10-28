@extends('layouts.admin')
@section('content')
<div class="bn-admin-workspace">
    @include('admin.partials.sidebar')
    <div class="bn-admin-main-shell" id="admin-main-shell">
        @include('admin.partials.topbar')
        <main id="main" class="bn-admin-main">
            <x-admin.feedback />
            @yield('workspace')
        </main>
        <footer class="bn-admin-workspace-footer"><span>© {{ date('Y') }} Better Nexus</span><span>Refined Remote Talent</span></footer>
    </div>
</div>
@endsection
