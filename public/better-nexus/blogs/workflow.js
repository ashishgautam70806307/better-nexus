(() => {
 'use strict';
 document.querySelectorAll('[data-delete-form]').forEach(f=>f.addEventListener('submit',e=>{if(!confirm('Delete this blog permanently?'))e.preventDefault();}));
 document.querySelectorAll('[data-editor]').forEach(box=>{
  const input=box.querySelector('textarea'),preview=box.querySelector('.bw-preview');let previous=[];
  function render(){preview.replaceChildren();for(const line of input.value.split('\n')){const heading=line.startsWith('## '),quote=line.startsWith('> ');const el=document.createElement(heading?'h2':quote?'blockquote':'p');let value=line.replace(/^(## |> )/,'');const parts=value.split(/(\*\*[^*]+\*\*|\*[^*]+\*|\[[^\]]+\]\(https?:\/\/[^\s)]+\))/g);for(const part of parts){if(part.startsWith('**')&&part.endsWith('**')){const n=document.createElement('strong');n.textContent=part.slice(2,-2);el.append(n);}else if(part.startsWith('*')&&part.endsWith('*')){const n=document.createElement('em');n.textContent=part.slice(1,-1);el.append(n);}else{const m=part.match(/^\[([^\]]+)\]\((https?:\/\/[^\s)]+)\)$/);if(m){const n=document.createElement('a');n.textContent=m[1];n.href=m[2];n.rel='noopener noreferrer';el.append(n);}else el.append(document.createTextNode(part.replace(/^- /,'• ')));}}preview.append(el);}}
  box.querySelector('[data-preview]').addEventListener('click',e=>{const show=preview.hidden;if(show)render();preview.hidden=!show;input.hidden=show;e.currentTarget.textContent=show?'Write':'Preview';});
  box.querySelectorAll('[data-format]').forEach(button=>button.addEventListener('click',()=>{
   preview.hidden=true;input.hidden=false;box.querySelector('[data-preview]').textContent='Preview';
   if(button.dataset.format==='undo'){if(previous.length)input.value=previous.pop();input.focus();return;}
   const start=input.selectionStart,end=input.selectionEnd,selected=input.value.slice(start,end)||'Text';let value=selected;
   switch(button.dataset.format){case 'bold':value='**'+selected+'**';break;case 'italic':value='*'+selected+'*';break;case 'heading':value='\n## '+selected+'\n';break;case 'list':value='\n'+selected.split('\n').map(x=>'- '+x).join('\n')+'\n';break;case 'number':value='\n'+selected.split('\n').map((x,i)=>(i+1)+'. '+x).join('\n')+'\n';break;case 'quote':value='\n> '+selected+'\n';break;case 'link':{const url=prompt('Enter an https:// link');if(!url)return;try{const u=new URL(url);if(!['https:','http:'].includes(u.protocol))throw Error();value='['+selected+']('+u.href+')';}catch{alert('Use a valid HTTP or HTTPS link.');return;}break;}}
   previous.push(input.value);if(previous.length>30)previous.shift();input.setRangeText(value,start,end,'select');input.dispatchEvent(new Event('input',{bubbles:true}));input.focus();
  }));
  input.addEventListener('invalid',()=>{input.hidden=false;preview.hidden=true;box.querySelector('[data-preview]').textContent='Preview';});
  input.form.addEventListener('submit',()=>{input.hidden=false;preview.hidden=true;});
 });
 document.querySelectorAll('[data-image-box]').forEach(box=>{const input=box.querySelector('[data-image-input]'),img=box.querySelector('[data-image-preview]'),error=box.querySelector('[data-image-error]');const original=img.getAttribute('src');let objectUrl=null;input.addEventListener('change',()=>{error.hidden=true;if(objectUrl)URL.revokeObjectURL(objectUrl);const file=input.files[0];if(!file)return;if(!['image/jpeg','image/png','image/webp'].includes(file.type)||file.size>4*1024*1024){input.value='';error.textContent='Choose JPG, PNG or WebP under 4 MB.';error.hidden=false;if(original){img.src=original;img.hidden=false;}else img.hidden=true;return;}objectUrl=URL.createObjectURL(file);img.src=objectUrl;img.hidden=false;const remove=box.querySelector('[name=remove_image]');if(remove)remove.checked=false;});});
})();
