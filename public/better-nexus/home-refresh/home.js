(() => {
  const root = document.querySelector('.bn-home26');
  if (!root || !('IntersectionObserver' in window) || window.matchMedia('(prefers-reduced-motion: reduce)').matches) return;
  const items = [...root.querySelectorAll('[data-bh-reveal]')];
  const observer = new IntersectionObserver((entries) => {
    entries.forEach(({target,isIntersecting}) => { if(isIntersecting){target.classList.add('bh-visible');observer.unobserve(target);} });
  }, {threshold:0.12,rootMargin:'0px 0px 40px 0px'});
  items.forEach(el => observer.observe(el));
  root.classList.add('bh-js');
})();

// Responsive CMS hero video: source switches by viewport, respects reduced motion and Save-Data.
(() => {
  const video=document.querySelector('[data-hero-film]');
  if (!video) return;
  const mobile=window.matchMedia('(max-width: 767px)');
  const reduced=window.matchMedia('(prefers-reduced-motion: reduce)');
  const toggle=document.querySelector('[data-hero-pause]');
  let userPaused=false;
  function update(){
    if(reduced.matches || navigator.connection?.saveData){video.pause();video.removeAttribute('src');video.load();video.hidden=true;if(toggle)toggle.hidden=true;return;}
    const next=(mobile.matches ? (video.dataset.mobile||video.dataset.desktop) : (video.dataset.desktop||video.dataset.mobile));
    if(!next){video.hidden=true;return;}
    if(video.getAttribute('src')!==next){video.src=next;video.load();}
    video.hidden=false;
    if(!userPaused)video.play().catch(()=>{video.hidden=true;});
    if(toggle)toggle.hidden=false;
  }
  video.addEventListener('error',()=>{video.hidden=true;if(toggle)toggle.hidden=true;});
  toggle?.addEventListener('click',()=>{userPaused=!userPaused;if(userPaused){video.pause();toggle.textContent='Play motion';toggle.setAttribute('aria-label','Play background video');}else{video.play().catch(()=>{video.hidden=true;});toggle.textContent='Pause motion';toggle.setAttribute('aria-label','Pause background video');}});
  mobile.addEventListener?.('change',update);reduced.addEventListener?.('change',update);
  navigator.connection?.addEventListener?.('change',update);update();
})();
