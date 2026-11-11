(()=>{'use strict';
  if(window.matchMedia('(prefers-reduced-motion: reduce)').matches)return;
  const items=[...document.querySelectorAll('#main .bn-reveal')];
  if(!items.length||!('IntersectionObserver' in window))return;
  document.documentElement.classList.add('bn-experience-motion');
  const observer=new IntersectionObserver((entries)=>{
    for(const entry of entries){if(entry.isIntersecting){entry.target.classList.add('bn-revealed');observer.unobserve(entry.target);}}
  },{threshold:.07,rootMargin:'0px 0px 60px 0px'});
  items.forEach((item,index)=>{item.style.setProperty('--bn-stagger',(index%4*65)+'ms');observer.observe(item);});
})();
