(()=>{'use strict';
  const main=document.getElementById('main');
  if(!main || !main.querySelector('.bn-how-section'))return;
  const reduceMotion=window.matchMedia('(prefers-reduced-motion: reduce)').matches;
  if(reduceMotion)return;
  // Apply to homepage content only. Exclude video hero (must remain continuously visible).
  const targets=[];
  main.querySelectorAll(':scope > section:not(.bn-clean-video-hero)').forEach(section=>{
    const content=section.querySelector('.va-wrap');
    if(!content)return;
    // Reveal small groups inside selected sections; do not hide entire sections or interactive controls.
    const cards=section.querySelectorAll('.bn-how-card,.bn-experience-service-card,.bn-experience-blog-card,.va-card');
    if(cards.length){
      const intro=section.querySelector('.bn-how-intro') || section.querySelector('.va-wrap > h2');
      if(intro)targets.push(intro);
      cards.forEach((card,i)=>{card.style.setProperty('--bn-delay',Math.min(i%4*65,195)+'ms');targets.push(card);});
    }else{
      const blocks=content.querySelectorAll(':scope > .va-split, :scope > .va-callout, :scope > h1, :scope > h2');
      blocks.forEach(el=>targets.push(el));
    }
  });
  if(!targets.length || !('IntersectionObserver' in window))return;
  // Do not temporarily hide sections on load before they enter viewport.
  const observer=new IntersectionObserver(entries=>{
    entries.forEach(entry=>{
      entry.target.classList.toggle('bn-home-inview',entry.isIntersecting);
    });
  },{threshold:0.06,rootMargin:'80px 0px 80px 0px'});
  targets.forEach(el=>{el.setAttribute('data-bn-home-reveal','');observer.observe(el);});
  main.classList.add('bn-home-motion-ready');
  // Pointer glow contained in process cards; uses no cursor replacement or global events.
  main.querySelectorAll('.bn-how-card').forEach(card=>{
    card.addEventListener('pointermove',event=>{
      if(event.pointerType==='touch')return;
      const bounds=card.getBoundingClientRect();
      card.style.setProperty('--pointer-x',((event.clientX-bounds.left)/bounds.width*100).toFixed(1)+'%');
      card.style.setProperty('--pointer-y',((event.clientY-bounds.top)/bounds.height*100).toFixed(1)+'%');
    },{passive:true});
  });
})();
