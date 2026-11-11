(()=>{'use strict';
const main=document.getElementById('main');if(!main)return;
const reduced=window.matchMedia('(prefers-reduced-motion: reduce)').matches;
// Annotate only public content: no header, navbar, hero video, footer or admin.
const eligible=[...main.querySelectorAll('section, .bn-journal-heading')].filter(section=>!section.matches('.bn-clean-video-hero,.bn-video-hero,.bn-hero')&&!section.closest('.bn-clean-video-hero'));
for(const section of eligible){
  const wrap=section.querySelector('.va-wrap')||section;
  const headings=wrap.querySelectorAll('.bn-about-heading,.va-blog-heading,.bn-experience-section-intro,.bn-experience-blog-toolbar');
  headings.forEach(el=>{if(!el.hasAttribute('data-aos'))el.setAttribute('data-aos','fade-up')});
  const firstHeading=wrap.querySelector('h2');if(firstHeading&&!firstHeading.closest('[data-aos]')&&!firstHeading.hasAttribute('data-aos'))firstHeading.setAttribute('data-aos','fade-up');
  // Stagger cards/steps; preserve existing explicitly-authored data-aos.
  const cards=wrap.querySelectorAll('.bn-how-card,.bn-experience-service-card,.bn-experience-blog-card,.bn-about-card,.bn-about-process-list > li,.bn-experience-task-grid > li,.va-cards > *, .va-service-grid > *, .bn-experience-blog-grid > *');
  [...new Set(cards)].forEach((el,i)=>{if(!el.hasAttribute('data-aos'))el.setAttribute('data-aos','fade-up');if(!el.hasAttribute('data-aos-delay'))el.setAttribute('data-aos-delay',String((i%4)*75))});
  if(cards.length===0&&!section.hasAttribute('data-aos')&&!section.querySelector('[data-aos]')){
    const blocks=wrap.querySelectorAll(':scope > .va-split,:scope > .va-callout,:scope > .bn-about-hero-grid,:scope > .bn-about-process-grid');
    blocks.forEach((el,i)=>el.setAttribute('data-aos',i%2?'fade-left':'fade-up'));
  }
}
if(reduced)return;
const targets=[...main.querySelectorAll('[data-aos]')];if(!targets.length)return;
// The actual AOS library runs when CDN is accessible; fallback works completely offline.
if(window.AOS&&typeof window.AOS.init==='function'){
  window.AOS.init({once:false,mirror:true,duration:680,easing:'ease-out-cubic',offset:60,disable:false});
  return;
}
if(!('IntersectionObserver'in window))return;
const io=new IntersectionObserver(entries=>{entries.forEach(entry=>entry.target.classList.toggle('bn-aos-visible',entry.isIntersecting))},{threshold:0.04,rootMargin:'40px 0px 40px 0px'});
targets.forEach(el=>{el.style.setProperty('--bn-aos-delay',Math.min(Number(el.getAttribute('data-aos-delay'))||0,225)+'ms');io.observe(el)});
document.documentElement.classList.add('bn-local-aos');
})();
