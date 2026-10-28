(() => {
    if (window.BetterNexus?.toast) return;
    const stack = document.querySelector('[data-bn-toasts]');
    if (!stack) return;
    function watch(toast) {
        const button = toast.querySelector('[data-toast-close]');
        button?.addEventListener('click', () => toast.remove());
        // Errors remain until dismissed. Other notices pause while focused/hovered.
        if (toast.classList.contains('bn-toast--error')) return;
        let timer;
        const pause = () => clearTimeout(timer);
        const resume = () => { pause(); timer = setTimeout(() => toast.remove(), 7000); };
        toast.addEventListener('mouseenter', pause);
        toast.addEventListener('mouseleave', resume);
        toast.addEventListener('focusin', pause);
        toast.addEventListener('focusout', resume);
        resume();
    }
    function show(message, type = 'success') {
        const tone = ['success','error','warning','info'].includes(type) ? type : 'info';
        const toast = document.createElement('div');
        toast.className = `bn-toast bn-toast--${tone}`;
        toast.setAttribute('role', tone === 'error' ? 'alert' : 'status');
        const icon = document.createElement('span'); icon.className = 'bn-toast-icon'; icon.textContent = tone === 'success' ? '✓' : '!'; icon.setAttribute('aria-hidden','true');
        const text = document.createElement('div'); text.textContent = String(message);
        const close = document.createElement('button'); close.type = 'button'; close.dataset.toastClose = ''; close.textContent = '×'; close.setAttribute('aria-label','Dismiss notification');
        toast.append(icon,text,close); stack.append(toast); watch(toast);
    }
    stack.querySelectorAll('[data-toast]').forEach(watch);
    window.BetterNexus = Object.assign(window.BetterNexus || {}, {toast:show});
    window.addEventListener('bn:toast', e => show(e.detail?.message || '', e.detail?.type || 'info'));
    document.addEventListener('submit', e => {
        if (!e.target.matches('[data-enquiry-delete]')) return;
        if (!confirm('Delete this enquiry permanently?')) e.preventDefault();
    });
})();