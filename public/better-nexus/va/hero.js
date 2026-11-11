(() => {
    const hero = document.querySelector('[data-va-video]');
    const video = hero?.querySelector('video');
    if (!video) return;

    const compact = matchMedia('(max-width: 650px)');
    const reduced = matchMedia('(prefers-reduced-motion: reduce)');
    let source = null;
    const load = (url) => {
        if (url === source) return;
        source = url;
        video.src = url;
        video.muted = true;
        video.play().catch(() => {
            if (source === url && video.paused) hero.hidden = true;
        });
    };
    const update = () => {
        if (reduced.matches || navigator.connection?.saveData) {
            source = null;
            video.pause();
            video.removeAttribute('src');
            video.load();
            hero.hidden = true;
            return;
        }
        load(compact.matches ? video.dataset.mobile : (video.dataset.upload || video.dataset.desktop));
    };
    video.addEventListener('playing', () => { hero.hidden = false; });
    video.addEventListener('error', () => {
        if (source && !compact.matches && source !== video.dataset.desktop) {
            load(video.dataset.desktop);
        } else {
            hero.hidden = true;
        }
    });
    compact.addEventListener?.('change', update);
    reduced.addEventListener?.('change', update);
    navigator.connection?.addEventListener?.('change', update);
    update();
})();
