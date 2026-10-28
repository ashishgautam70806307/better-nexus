@once
<link rel="stylesheet" href="{{ asset('better-nexus/shared/feedback.css') }}?v=1">
<div class="bn-toast-stack" data-bn-toasts aria-label="Notifications">
    @foreach(['success'=>'success','status'=>'success','error'=>'error','warning'=>'warning','info'=>'info'] as $key=>$tone)
        @if(session($key))
            <div class="bn-toast bn-toast--{{ $tone }}" role="{{ $tone==='error' ? 'alert' : 'status' }}" data-toast>
                <span class="bn-toast-icon" aria-hidden="true">{{ $tone==='success' ? '✓' : '!' }}</span>
                <div>{{ session($key) }}</div><button type="button" data-toast-close aria-label="Dismiss notification">×</button>
            </div>
        @endif
    @endforeach
    @if($errors->any())
        <div class="bn-toast bn-toast--error" role="alert" data-toast>
            <span class="bn-toast-icon" aria-hidden="true">!</span>
            <div><strong>Please check your details.</strong><p>{{ $errors->first() }}</p></div>
            <button type="button" data-toast-close aria-label="Dismiss notification">×</button>
        </div>
    @endif
</div>
<script src="{{ asset('better-nexus/shared/feedback.js') }}?v=1" defer></script>
@endonce
