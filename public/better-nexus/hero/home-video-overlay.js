/* Homepage cursor enhancement: no libraries, no cursor replacement, no layout changes. */
(() => {
  'use strict';
  const body = document.body;
  if (!body.classList.contains('bn-video-home')) return;
  const fine = window.matchMedia('(hover: hover) and (pointer: fine)');
  const reduced = window.matchMedia('(prefers-reduced-motion: reduce)');
  if (!fine.matches || reduced.matches) return;

  const hero = document.querySelector('#main .bn-clean-video-hero');
  const main = document.querySelector('#main');
  if (!main) return;
  const orb = document.createElement('div');
  orb.className = 'bn-liquid-cursor';
  orb.setAttribute('aria-hidden', 'true');
  body.append(orb);
  const dots = Array.from({length:3}, (_, i) => {
    const dot = document.createElement('div');
    dot.className = 'bn-liquid-dot';
    dot.style.width = `${10 - i * 2}px`;
    dot.style.height = `${10 - i * 2}px`;
    dot.style.opacity = '0';
    dot.setAttribute('aria-hidden', 'true');
    body.append(dot);
    return {element: dot, x:-150, y:-150};
  });
  let px = -150, py = -150, ox = -150, oy = -150, alive = false, raf = 0;
  const moveElement = (element,x,y) => {element.style.transform = `translate3d(${x}px,${y}px,0) translate(-50%,-50%)`;};
  const frame = () => {
    if (!alive || document.hidden || !fine.matches || reduced.matches) {raf=0; return;}
    ox += (px - ox) * .24;
    oy += (py - oy) * .24;
    moveElement(orb,ox,oy);
    let previousX = ox, previousY = oy;
    dots.forEach((dot,i) => {
      const ease = .22 - i*.035;
      dot.x += (previousX-dot.x)*ease;
      dot.y += (previousY-dot.y)*ease;
      moveElement(dot.element,dot.x,dot.y);
      previousX=dot.x;previousY=dot.y;
    });
    raf = requestAnimationFrame(frame);
  };
  const reveal = () => {
    if (!alive) { alive=true; orb.classList.add('is-visible'); dots.forEach(d=>d.element.classList.add('is-visible')); if(!raf)raf=requestAnimationFrame(frame); }
  };
  const hide = () => {alive=false; orb.classList.remove('is-visible','is-active');dots.forEach(d=>d.element.classList.remove('is-visible'));};
  document.addEventListener('pointermove', event => {
    if (event.pointerType !== 'mouse' && event.pointerType !== 'pen') return;
    px = event.clientX; py = event.clientY;
    if (ox < 0) {ox=px;oy=py;dots.forEach(d=>{d.x=px;d.y=py;});}
    reveal();
    const target = event.target instanceof Element ? event.target : null;
    const active = Boolean(target?.closest('a,button,summary,[role="button"],.va-card,.va-step-card,.bn-experience-card'));
    orb.classList.toggle('is-active', active);
    const card = target?.closest('#main .va-card,#main .va-step-card,#main .bn-experience-card');
    if (card) {
      card.classList.add('bn-liquid-hover');
      const rect=card.getBoundingClientRect();
      card.style.setProperty('--bn-glow-x',`${event.clientX-rect.left}px`);
      card.style.setProperty('--bn-glow-y',`${event.clientY-rect.top}px`);
    }
    if (hero && hero.contains(target)) {
      const r=hero.getBoundingClientRect();
      hero.style.setProperty('--bn-mouse-x', `${Math.max(0,Math.min(100,(px-r.left)/r.width*100))}%`);
      hero.style.setProperty('--bn-mouse-y', `${Math.max(0,Math.min(100,(py-r.top)/r.height*100))}%`);
      hero.style.setProperty('--bn-wave-strength','1');
    } else if(hero) hero.style.setProperty('--bn-wave-strength','0');
  },{passive:true});
  document.addEventListener('pointerout',event=>{if(!event.relatedTarget){hide();if(hero)hero.style.setProperty('--bn-wave-strength','0');}},{passive:true});
  window.addEventListener('blur',hide);
  document.addEventListener('visibilitychange',()=>{if(document.hidden) hide();});
  document.addEventListener('pointerdown',event=>{
    if (!alive || event.pointerType !== 'mouse') return;
    const ripple=document.createElement('div');
    ripple.className='bn-click-ripple';
    ripple.setAttribute('aria-hidden','true');
    ripple.style.left=`${event.clientX}px`;ripple.style.top=`${event.clientY}px`;
    body.append(ripple);
    ripple.addEventListener('animationend',()=>ripple.remove(),{once:true});
  },{passive:true});
  const mqChange=()=>{if(!fine.matches||reduced.matches){hide();if(raf){cancelAnimationFrame(raf);raf=0;}}};
  fine.addEventListener('change',mqChange);reduced.addEventListener('change',mqChange);
})();
