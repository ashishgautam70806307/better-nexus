(()=>{'use strict';
  const video=document.querySelector('#main .bn-clean-video-hero [data-bn-clean-video]');
  if(!video)return;
  const mobile=window.matchMedia('(max-width: 767px)');
  const reduced=window.matchMedia('(prefers-reduced-motion: reduce)');
  const desktop=video.dataset.desktop||'';const phone=video.dataset.mobile||desktop;
  function update(){
    const saveData=Boolean(navigator.connection?.saveData);
    if(reduced.matches||saveData){video.pause();video.hidden=true;return;}
    const src=mobile.matches?phone:desktop;
    if(!src){video.pause();video.hidden=true;return;}
    if(video.getAttribute('src')!==src){video.pause();video.setAttribute('src',src);video.load();}
    video.hidden=false;
    const play=video.play();if(play&&typeof play.catch==='function')play.catch(()=>{video.hidden=true;});
  }
  video.addEventListener('error',()=>{video.hidden=true;});
  mobile.addEventListener?.('change',update);
  reduced.addEventListener?.('change',update);
  navigator.connection?.addEventListener?.('change',update);
  if(document.readyState==='loading')document.addEventListener('DOMContentLoaded',update,{once:true});else update();
})();
