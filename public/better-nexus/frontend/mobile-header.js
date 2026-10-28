/* Native details is the toggle; do not bind the old .bn2-menu-toggle handler. */
(() => {
    'use strict';
    const header = document.querySelector('[data-bn-responsive-header]');
    const menu = header?.querySelector('[data-bn-mobile-menu]');
    const toggle = menu?.querySelector('.bn-mobile-toggle');
    if (!header || !menu || !toggle || menu.dataset.bound) return;
    menu.dataset.bound = 'true';
    const mobile = matchMedia('(max-width:1024px)');
    function updateLabel() {
        toggle.setAttribute('aria-expanded', String(menu.open));
        toggle.setAttribute('aria-label', menu.open ? 'Close navigation' : 'Open navigation');
    }
    function close(restoreFocus = false) {
        menu.open = false;
        updateLabel();
        if (restoreFocus) toggle.focus();
    }
    menu.addEventListener('toggle', updateLabel);
    document.addEventListener('pointerdown', event => {
        if (menu.open && !menu.contains(event.target)) close();
    });
    document.addEventListener('keydown', event => {
        if (event.key === 'Escape' && menu.open) {
            event.preventDefault();
            close(true);
        }
    });
    menu.addEventListener('focusout', () => {
        requestAnimationFrame(() => {
            if (menu.open && !menu.contains(document.activeElement)) close();
        });
    });
    menu.querySelectorAll('a').forEach(link => link.addEventListener('click', () => close()));
    mobile.addEventListener('change', () => {
        close();
        header.querySelectorAll('.bn2-nav details[open]').forEach(details => { details.open = false; });
    });
    addEventListener('pageshow', () => close());
    updateLabel();
})();
