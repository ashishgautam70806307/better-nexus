/* Better Nexus admin v3. Existing auth endpoints are unchanged. */
(() => {
    'use strict';
    document.querySelectorAll('[data-password-toggle]').forEach(button => {
        const input = document.getElementById(button.dataset.passwordToggle);
        if (!input) return;
        button.hidden = false;
        const label = button.getAttribute('aria-label');
        button.addEventListener('click', () => {
            const reveal = input.type === 'password';
            input.type = reveal ? 'text' : 'password';
            button.setAttribute('aria-pressed', String(reveal));
            button.setAttribute('aria-label', reveal ? label.replace('Show', 'Hide') : label);
        });
    });
    document.querySelectorAll('[data-admin-submit]').forEach(form => {
        const button = form.querySelector('[data-submit-button]');
        const label = button?.querySelector('[data-submit-label]');
        if (!button || !label) return;
        const original = label.textContent;
        form.addEventListener('submit', () => {
            button.disabled = true;
            label.textContent = 'Please wait…';
            form.setAttribute('aria-busy', 'true');
        });
        addEventListener('pageshow', () => {
            button.disabled = false;
            label.textContent = original;
            form.removeAttribute('aria-busy');
        });
    });
    const sidebar = document.getElementById('admin-sidebar');
    const shell = document.getElementById('admin-main-shell');
    const toggle = document.querySelector('[data-sidebar-open]');
    const backdrop = document.querySelector('.bn-admin-sidebar-backdrop');
    if (sidebar && shell && toggle && backdrop) {
        const mobile = matchMedia('(max-width:1000px)');
        let open = false, rail = false;
        try { rail = localStorage.getItem('bn-admin-sidebar-compact') === 'true'; } catch (_) { /* Storage can be disabled. */ }
        toggle.hidden = false;
        document.body.classList.add('bn-admin-nav-ready');
        function sync() {
            const narrow = mobile.matches;
            sidebar.inert = narrow && !open;
            shell.inert = narrow && open;
            document.body.classList.toggle('bn-admin-menu-open', narrow && open);
            document.body.classList.toggle('bn-admin-rail', !narrow && rail);
            backdrop.hidden = !(narrow && open);
            toggle.setAttribute('aria-expanded', String(narrow ? open : !rail));
            toggle.setAttribute('aria-label', narrow ? (open ? 'Close navigation' : 'Open navigation') : (rail ? 'Expand sidebar' : 'Collapse sidebar'));
        }
        function close(restore = true) {
            open = false; sync();
            if (restore && mobile.matches) toggle.focus();
        }
        toggle.addEventListener('click', () => {
            if (mobile.matches) {
                open = !open; sync();
                if (open) sidebar.querySelector('[data-sidebar-close]')?.focus();
            } else {
                rail = !rail;
                try { localStorage.setItem('bn-admin-sidebar-compact', String(rail)); } catch (_) { /* Optional preference only. */ }
                sync();
            }
        });
        document.querySelectorAll('[data-sidebar-close]').forEach(el => el.addEventListener('click', () => close()));
        sidebar.querySelectorAll('a').forEach(link => link.addEventListener('click', () => { if (mobile.matches) close(); }));
        mobile.addEventListener('change', () => {
            const hadFocus = sidebar.contains(document.activeElement);
            close(false);
            if (mobile.matches && hadFocus) toggle.focus();
        });
        document.addEventListener('keydown', event => {
            if (!open || !mobile.matches) return;
            if (event.key === 'Escape') { event.preventDefault(); close(); }
            if (event.key === 'Tab') {
                const controls = [...sidebar.querySelectorAll('a[href],button:not([disabled])')].filter(el => el.getClientRects().length);
                const first = controls[0], last = controls[controls.length - 1];
                if (event.shiftKey && document.activeElement === first) { event.preventDefault(); last?.focus(); }
                else if (!event.shiftKey && document.activeElement === last) { event.preventDefault(); first?.focus(); }
            }
        });
        sync();
    }
    const input = document.querySelector('[data-library-input]');
    const items = [...document.querySelectorAll('[data-library-item]')];
    if (input && items.length) {
        document.querySelector('[data-library-tools]').hidden = false;
        document.querySelector('[data-library-pagination]').hidden = false;
        const filters = [...document.querySelectorAll('[data-library-filter]')];
        const prev = document.querySelector('[data-library-prev]');
        const next = document.querySelector('[data-library-next]');
        const result = document.querySelector('[data-library-result]');
        const label = document.querySelector('[data-library-page]');
        const empty = document.querySelector('[data-library-empty]');
        const pageSize = 6;
        let kind = 'all', page = 1;
        function render() {
            const query = input.value.trim().toLocaleLowerCase();
            const matching = items.filter(item => (kind === 'all' || item.dataset.kind === kind) && item.textContent.toLocaleLowerCase().includes(query));
            const pages = Math.max(1, Math.ceil(matching.length / pageSize));
            page = Math.min(Math.max(1, page), pages);
            const start = (page - 1) * pageSize;
            const visible = new Set(matching.slice(start, start + pageSize));
            items.forEach(item => { item.hidden = !visible.has(item); });
            filters.forEach(button => button.setAttribute('aria-pressed', String(button.dataset.libraryFilter === kind)));
            empty.hidden = matching.length > 0;
            prev.disabled = page === 1;
            next.disabled = page === pages;
            result.textContent = matching.length ? `Showing ${start + 1}–${Math.min(start + pageSize, matching.length)} of ${matching.length} pages` : 'No matching pages';
            label.textContent = `Page ${page} of ${pages}`;
        }
        input.addEventListener('input', () => { page = 1; render(); });
        filters.forEach(button => button.addEventListener('click', () => { kind = button.dataset.libraryFilter; page = 1; render(); }));
        prev.addEventListener('click', () => { page--; render(); if (prev.disabled) next.focus(); });
        next.addEventListener('click', () => { page++; render(); if (next.disabled) prev.focus(); });
        document.querySelector('[data-library-reset]')?.addEventListener('click', () => { input.value = ''; kind = 'all'; page = 1; render(); input.focus(); });
        function focusSearch() { input.focus(); input.scrollIntoView({ block: 'center', behavior: 'auto' }); }
        document.querySelectorAll('[data-focus-search]').forEach(link => link.addEventListener('click', event => { event.preventDefault(); focusSearch(); }));
        document.addEventListener('keydown', event => { if ((event.ctrlKey || event.metaKey) && event.key.toLowerCase() === 'k') { event.preventDefault(); focusSearch(); } });
        render();
    }
    const profile = document.querySelector('.bn-admin-profile');
    if (profile) {
        document.addEventListener('click', event => { if (!profile.contains(event.target)) profile.open = false; });
        document.addEventListener('keydown', event => { if (event.key === 'Escape' && profile.open) { profile.open = false; profile.querySelector('summary').focus(); } });
    }
})();
