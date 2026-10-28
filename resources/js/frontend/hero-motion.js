/* Self-contained hero media: no vendor dependency; Laravel safe. */
(()=>{'use strict';
const hero=document.querySelector('.bn2-home-hero');if(!hero||hero.dataset.originalHeroReady)return;hero.dataset.originalHeroReady='true';
const video=hero.querySelector('video'),button=hero.querySelector('.bn8-motion-toggle'),cards=[...hero.querySelectorAll('.bn2-orbit-card')];
const reduced=matchMedia('(prefers-reduced-motion:reduce)');let running=false,visible=true,frame=0,phase=0,last=0,started=performance.now();
const label=button?.querySelector('.bn8-motion-label');
function draw(){const w=hero.clientWidth,h=hero.clientHeight,rx=w<600?w*.48:Math.min(w*.43,680),ry=w<600?275:Math.min(h*.38,335);cards.forEach((el,i)=>{const a=i/cards.length*Math.PI*2-.3+phase;el.style.setProperty('--x',(Math.cos(a)*rx).toFixed(2)+'px');el.style.setProperty('--y',(Math.sin(a)*ry).toFixed(2)+'px')})}
function loop(now){if(!running||!visible||document.hidden){frame=0;last=0;return}if(last&&now-started>2300)phase+=(now-last)/1000*Math.PI*2/100;last=now;draw();frame=requestAnimationFrame(loop)}
function sync(){hero.classList.toggle('bn8-motion-paused',!running);button?.setAttribute('aria-pressed',String(running));button?.setAttribute('aria-label',running?'Pause background motion':'Play background motion');if(label)label.textContent=running?'Pause motion':'Play motion';if(button)button.firstElementChild.textContent=running?'Ⅱ':'▶'}
function resume(){if(running&&visible&&!document.hidden){video?.play().catch(()=>{});if(!frame)frame=requestAnimationFrame(loop)}}
function setRunning(value){running=value;sync();if(running)resume();else{video?.pause();cancelAnimationFrame(frame);frame=0;last=0}}
button?.addEventListener('click',()=>setRunning(!running));
video?.addEventListener('error',()=>{video.hidden=true});
new IntersectionObserver(entries=>{visible=entries[0].isIntersecting;if(visible)resume();else{video?.pause();cancelAnimationFrame(frame);frame=0;last=0}},{threshold:0}).observe(hero);
document.addEventListener('visibilitychange',()=>{if(document.hidden){video?.pause();cancelAnimationFrame(frame);frame=0;last=0}else resume()});
reduced.addEventListener('change',()=>setRunning(!reduced.matches&&!navigator.connection?.saveData));addEventListener('resize',draw);draw();setRunning(!reduced.matches&&!navigator.connection?.saveData);
})();
