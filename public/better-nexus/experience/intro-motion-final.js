(()=>{'use strict';
const main=document.querySelector('main#main');if(!main)return;
const reduced=matchMedia('(prefers-reduced-motion: reduce)').matches;
const heroSelector='.bn-clean-video-hero,.bn-video-hero,.bn-hero';
const sections=[...main.querySelectorAll('section')].filter(s=>!s.matches(heroSelector)&&!s.closest(heroSelector));
// Animate actual section elements, never the sticky navigation or hero video.
for(const section of sections){
 const root=section.querySelector('.va-wrap')||section;
 const preferred=[...root.children].filter(el=>el.matches('.bn-about-heading,.bn-journal-heading,.bn-how-intro,.bn-about-hero-grid,.bn-about-process-grid,.va-split,.va-callout,.bn-intro-premium,.bn-experience-section-intro,.bn-experience-blog-toolbar'));
 preferred.forEach((el,i)=>{if(!el.hasAttribute('data-aos')&&!el.querySelector('[data-aos]'))el.setAttribute('data-aos',i%2?'fade-left':'fade-up')});
 // Section headline/summary: avoid animating parents which contain already animated children.
 const headings=[...root.querySelectorAll(':scope > h1,:scope > h2,:scope > p,:scope > .va-kicker')];
 headings.forEach((el,i)=>{if(!el.hasAttribute('data-aos')&&!el.closest('[data-aos]')){el.setAttribute('data-aos','fade-up');el.setAttribute('data-aos-delay',String(Math.min(i*65,180)))}});
 // Card collections: support multiple home components, related blogs and FAQs.
 const selectors=['.bn-how-grid > li','.va-service-grid > *','.va-cards > *','.bn-experience-blog-grid > *','.bn-about-card-grid > *','.bn-about-process-list > li','.bn-experience-task-grid > li','.bn-experience-related .va-service-grid > *','.va-faq-list > *','.va-accordion > *'];
 const cards=[...new Set([...root.querySelectorAll(selectors.join(','))])];
 cards.forEach((card,i)=>{if(!card.hasAttribute('data-aos')&&!card.closest('[data-aos]'))card.setAttribute('data-aos','fade-up');if(!card.hasAttribute('data-aos-delay'))card.setAttribute('data-aos-delay',String((i%4)*65))});
 // Generic sections: reveal direct visual or text elements only when nothing explicit is marked.
 if(!root.querySelector('[data-aos]')){
  const direct=[...root.children].filter(el=>!el.matches('script,style'));
  (direct.length?direct:[root]).forEach((el,i)=>{if(!el.hasAttribute('data-aos'))el.setAttribute('data-aos',i%2?'fade-left':'fade-up')});
 }
}
const targets=[...main.querySelectorAll('[data-aos]')].filter(el=>!el.closest(heroSelector));
if(reduced||!targets.length)return;
// Prefer full AOS (with bidirectional mirror). Offline fallback uses IntersectionObserver.
if(window.AOS&&typeof window.AOS.init==='function'){
 window.AOS.init({once:false,mirror:true,duration:650,easing:'ease-out-cubic',offset:45,anchorPlacement:'top-bottom'});
 window.AOS.refreshHard?.();
 return;
}
if(!('IntersectionObserver'in window))return;
const observer=new IntersectionObserver(entries=>{
 for(const entry of entries)entry.target.classList.toggle('bn-final-visible',entry.isIntersecting);
},{threshold:0.035,rootMargin:'28px 0px 28px 0px'});
for(const el of targets){el.style.setProperty('--bn-final-delay',Math.min(parseInt(el.getAttribute('data-aos-delay')||'0',10)||0,200)+'ms');observer.observe(el)}
document.documentElement.classList.add('bn-final-aos');
})();
