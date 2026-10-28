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

 const sidebar=document.getElementById('admin-sidebar');
 const toggle=document.querySelector('[data-sidebar-open]');
 const backdrop=document.querySelector('.bn-admin-sidebar-backdrop');
 const shell=document.getElementById('admin-main-shell');
 if(!sidebar||!toggle||!backdrop||!shell)return;
 const mobile=matchMedia('(max-width:1000px)');let open=false,collapsed=false;
 function sync(){document.body.classList.toggle('premium-menu-open',mobile.matches&&open);document.body.classList.toggle('premium-collapsed',!mobile.matches&&collapsed);backdrop.hidden=!(mobile.matches&&open);sidebar.inert=mobile.matches&&!open;toggle.hidden=false;toggle.setAttribute('aria-expanded',String(mobile.matches?open:!collapsed));toggle.setAttribute('aria-label',mobile.matches?'Open navigation':(collapsed?'Expand sidebar':'Collapse sidebar'));}
 function close(){open=false;sync();toggle.focus();}
 toggle.addEventListener('click',()=>{if(mobile.matches){open=!open;sync();if(open)sidebar.querySelector('button,a')?.focus();}else{collapsed=!collapsed;sync();}});
 backdrop.addEventListener('click',close);sidebar.querySelector('[data-premium-close]')?.addEventListener('click',close);
 document.addEventListener('keydown',e=>{if(!mobile.matches||!open)return;if(e.key==='Escape'){e.preventDefault();close();}if(e.key==='Tab'){const nodes=[...sidebar.querySelectorAll('a[href],button')].filter(x=>!x.disabled);const first=nodes[0],last=nodes[nodes.length-1];if(e.shiftKey&&document.activeElement===first){e.preventDefault();last.focus();}else if(!e.shiftKey&&document.activeElement===last){e.preventDefault();first.focus();}}});
 mobile.addEventListener('change',()=>{open=false;collapsed=false;sync();});sync();
})();
