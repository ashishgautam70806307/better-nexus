@php
    // No database helpers, auth calls, session reads or named route dependencies here.
    $code = (int) ($errorCode ?? 500);
    $adminPath = request()->is('admin', 'admin/*');
    $homeUrl = url('/');
    $accountUrl = url('/admin/login');
    $retryUrl = request()->isMethod('GET') ? url()->current() : ($adminPath ? url('/admin') : $homeUrl);
    $canRetry = in_array($code, [408, 429, 500, 502, 503, 504, 507], true);
    $brand = config('app.name');
    $brand = !$brand || $brand === 'Laravel' ? 'Better Nexus' : $brand;
@endphp
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex, nofollow">
    <meta name="theme-color" content="#f4f8f5">
    <title>{{ $code }} · {{ $errorTitle }} | {{ $brand }}</title>
    <style>
        :root{color-scheme:light;--ink:#23453c;--muted:#7d9187;--green:#126562;--line:#dfe9e2}
        *{box-sizing:border-box}body{margin:0;min-height:100vh;min-height:100svh;background:radial-gradient(ellipse at 12% 6%,#dfede580,transparent 45%),radial-gradient(ellipse at 90% 95%,#e7eee3,transparent 45%),#f5f8f5;color:var(--ink);font:14px/1.6 system-ui,-apple-system,BlinkMacSystemFont,"Segoe UI",sans-serif}a{color:inherit}button{font:inherit}a:focus-visible,button:focus-visible{outline:3px solid #238d7755;outline-offset:4px}.bn-error-shell{width:min(100% - 40px,1000px);margin:auto;min-height:100vh;min-height:100svh;display:flex;flex-direction:column}.bn-error-top{display:flex;align-items:center;justify-content:space-between;gap:18px;padding:26px 0}.bn-error-brand{display:inline-flex;align-items:center;gap:10px;text-decoration:none;font-weight:700;font-size:15px;letter-spacing:-.025em}.bn-error-brand-mark{display:grid;place-items:center;width:32px;height:34px;background:#e4f0e9;border:1px solid #cfe1d6;border-radius:9px;color:var(--green)}.bn-error-brand-mark svg{width:19px;height:19px}.bn-error-top>span{font-size:10px;color:#8a9d91;letter-spacing:.1em}.bn-error-main{flex:1;display:grid;place-items:center;padding:20px 0 38px}.bn-error-wrap{width:min(100%,820px)}.bn-error-card{display:grid;grid-template-columns:minmax(0,1fr) 225px;overflow:hidden;background:#fff;border:1px solid var(--line);border-radius:18px;box-shadow:0 12px 45px #29473508}.bn-error-content{padding:35px}.bn-error-label{display:inline-flex;align-items:center;gap:7px;font-size:9px;letter-spacing:.13em;font-weight:700;color:#7a9586}.bn-error-label>i{width:6px;height:6px;background:#6fa78d;border-radius:50%}h1{font-size:clamp(24px,3vw,31px);line-height:1.25;letter-spacing:-.04em;margin:16px 0 13px;font-weight:650}.bn-error-description{font-size:13px;line-height:1.85;color:var(--muted);margin:0;max-width:400px;overflow-wrap:anywhere}.bn-error-actions{display:flex;align-items:center;gap:10px;flex-wrap:wrap;margin-top:25px}.bn-error-button{display:inline-flex;align-items:center;justify-content:center;gap:17px;min-height:39px;padding:9px 15px;text-decoration:none;font-size:11px;font-weight:600;border:1px solid #d8e5db;background:#fff;color:#4b705e;border-radius:7px;cursor:pointer;transition:background .15s}.bn-error-button:hover{background:#eef6f0}.bn-error-button--primary{background:var(--green);border-color:var(--green);color:#fff}.bn-error-button--primary:hover{background:#0a4d4a}.bn-error-button[hidden]{display:none}.bn-error-code-panel{position:relative;display:flex;flex-direction:column;align-items:center;justify-content:center;gap:17px;padding:25px;border-left:1px solid #e4ece5;background:radial-gradient(circle at 80% 15%,#dfede0,transparent 65%),#f0f6ef}.bn-error-orbit{display:grid;place-items:center;width:88px;height:88px;border:1px solid #d1e2d4;border-radius:50%;background:#ffffff70;position:relative}.bn-error-orbit:before{content:"";position:absolute;inset:8px;border:1px dashed #c5d9c9;border-radius:50%}.bn-error-orbit svg{width:34px;height:34px;stroke:#669e82;fill:none;stroke-width:1.4}.bn-error-code{font-size:57px;font-weight:650;letter-spacing:-.07em;line-height:1;color:#487f66}.bn-error-code-caption{font-size:9px;letter-spacing:.16em;color:#95ad9c;font-weight:600}.bn-error-help{display:flex;align-items:center;justify-content:space-between;gap:15px;border:1px solid var(--line);background:#ffffff80;border-radius:11px;padding:14px 18px;margin-top:14px}.bn-error-help strong{font-size:11px;font-weight:600}.bn-error-help p{font-size:11px;color:#879a8c;margin:2px 0 0}.bn-error-help a{font-size:11px;font-weight:600;text-decoration:none;white-space:nowrap;color:#40775e}.bn-error-help a:hover{text-decoration:underline}.bn-error-footer{display:flex;justify-content:space-between;align-items:center;gap:12px;padding:17px 0 22px;color:#92a296;font-size:10px}.bn-error-footer a{text-decoration:none}.bn-error-footer a:hover{text-decoration:underline}.bn-error-note{font-size:10px;color:#91a195;margin:14px 2px 0}
        @media(max-width:640px){.bn-error-shell{width:calc(100% - 30px)}.bn-error-top{padding:20px 0}.bn-error-top>span{display:none}.bn-error-main{padding:12px 0 25px}.bn-error-card{grid-template-columns:1fr}.bn-error-content{padding:26px 23px}.bn-error-code-panel{grid-row:1;border-left:0;border-bottom:1px solid var(--line);flex-direction:row;gap:18px;padding:20px}.bn-error-orbit{width:50px;height:50px}.bn-error-orbit:before{inset:5px}.bn-error-orbit svg{width:24px;height:24px}.bn-error-code{font-size:43px}.bn-error-code-caption{font-size:8px}h1{font-size:25px}.bn-error-description{font-size:13px}.bn-error-help{padding:13px 15px;align-items:start;flex-direction:column;gap:8px}.bn-error-actions{gap:9px}.bn-error-button{font-size:12px;min-height:42px}.bn-error-footer{font-size:9px;flex-wrap:wrap}.bn-error-note{font-size:10px}}
        @media(prefers-reduced-motion:reduce){.bn-error-button{transition:none}}
    </style>
</head>
<body>
<div class="bn-error-shell">
    <header class="bn-error-top">
        <a class="bn-error-brand" href="{{ $homeUrl }}"><span class="bn-error-brand-mark" aria-hidden="true"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7"><path d="M5 18V6l14 12V6M5 6h5M14 18h5"/></svg></span>{{ $brand }}</a>
        <span>LET’S GET YOU BACK ON TRACK</span>
    </header>
    <main class="bn-error-main">
        <div class="bn-error-wrap">
            <section class="bn-error-card" aria-labelledby="error-title">
                <div class="bn-error-content">
                    <span class="bn-error-label"><i aria-hidden="true"></i>{{ $errorLabel }}</span>
                    <h1 id="error-title">{{ $errorTitle }}</h1>
                    <p class="bn-error-description">{{ $errorMessage }}</p>
                    <div class="bn-error-actions">
                        @if(in_array($code, [401,419], true) && $adminPath)
                            <a class="bn-error-button bn-error-button--primary" href="{{ $accountUrl }}">Sign in again <span aria-hidden="true">↗</span></a>
                        @elseif($code===419 && request()->is('contact-us'))
                            <a class="bn-error-button bn-error-button--primary" href="{{ url('/contact-us') }}">Open contact form <span aria-hidden="true">↗</span></a>
                        @else
                            <a class="bn-error-button bn-error-button--primary" href="{{ $homeUrl }}">Back to home <span aria-hidden="true">↗</span></a>
                        @endif
                        @if($canRetry)
                            <a class="bn-error-button" href="{{ $retryUrl }}">Try again <span aria-hidden="true">↻</span></a>
                        @else
                            <button class="bn-error-button" type="button" id="error-back" hidden>Go back <span aria-hidden="true">←</span></button>
                        @endif
                    </div>
                </div>
                <div class="bn-error-code-panel" aria-hidden="true">
                    <span class="bn-error-orbit"><svg viewBox="0 0 48 48"><path d="M15 6h13l8 8v27H12V6h3Z"/><path d="M28 6v9h8M19 23h10M19 29h6"/><circle cx="34" cy="35" r="9" fill="#f0f6ef"/><path d="M34 30v6m0 3v1"/></svg></span>
                    <strong class="bn-error-code">{{ $code }}</strong><span class="bn-error-code-caption">HTTP STATUS</span>
                </div>
            </section>
            <aside class="bn-error-help"><div><strong>Need a little help?</strong><p>Share this error code with our team: {{ $code }}.</p></div><a href="{{ url('/contact-us') }}">Contact the team <span aria-hidden="true">↗</span></a></aside>
            @if(in_array($code, [419,429,500,502,503,504],true))
                <p class="bn-error-note">@if($code===429)Please wait before trying again. Repeated refreshes may extend the limit.@elseif($code===419)Reopen the form before submitting again.@else Please check whether your last action completed before submitting it again.@endif</p>
            @endif
        </div>
    </main>
    <footer class="bn-error-footer"><span>© {{ date('Y') }} {{ $brand }}</span><span>Error {{ $code }} · <a href="{{ $homeUrl }}">Homepage</a></span></footer>
</div>
<script>
    (() => {
        const button = document.getElementById('error-back');
        if (!button || !document.referrer) return;
        try {
            const previous = new URL(document.referrer);
            if (previous.origin !== window.location.origin || previous.href === window.location.href) return;
            button.hidden = false;
            button.addEventListener('click', () => window.location.assign(previous.href));
        } catch (_) { /* Home remains available when the referrer cannot be used. */ }
    })();
</script>
</body>
</html>
