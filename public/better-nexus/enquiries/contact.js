(() => {
    const form=document.getElementById('bn-contact-live');
    if(!form)return;
    const names=['name','email','phone','subject','message'];
    const summary=form.querySelector('[data-form-summary]');
    const submit=form.querySelector('[data-contact-submit]');
    const label=submit.querySelector('span').textContent;
    let sending=false;
    const count=form.querySelector('[data-message-count]');
    function length(value){return Array.from(value).length;}
    function error(field){
        const v=field.value.trim(),n=field.name;
        if(field.required&&!v)return n==='message'?'Please tell us what you need.':`Please enter your ${n==='name'?'name':'email address'}.`;
        if(n==='name'&&v&&(length(v)<2||length(v)>120||!/[\p{L}]/u.test(v)))return 'Enter a name with 2–120 characters, containing letters.';
        if(n==='email'&&v&&(field.validity.typeMismatch||length(v)>255))return 'Please enter a valid email address.';
        if(n==='phone'&&v&&!/^[0-9]{10,12}$/.test(v))return 'Enter 10–12 digits only; no +, spaces or dashes.';
        if(n==='subject'&&length(v)>180)return 'Use 180 characters or fewer.';
        if(n==='message'&&v&&(length(v)<10||length(v)>5000))return 'Write a message with 10–5,000 characters.';
        return '';
    }
    function validate(field){
        const message=error(field),target=form.querySelector(`[data-error="${field.name}"]`);
        target.textContent=message;
        field.setAttribute('aria-invalid',String(Boolean(message)));
        return !message;
    }
    function updateCount(){count.textContent=`${length(form.elements.message.value)} / 5,000`;}
    // Native validation remains as fallback when JavaScript is unavailable.
    form.noValidate=true;
    names.forEach(name=>{
        const input=form.elements[name];
        input.addEventListener('blur',()=>{input.dataset.touched='1';validate(input);});
        input.addEventListener('input',()=>{if(input.dataset.touched||input.getAttribute('aria-invalid')==='true')validate(input);});
    });
    form.elements.message.addEventListener('input',updateCount);updateCount();
    form.addEventListener('submit',event=>{
        if(sending){event.preventDefault();return;}
        let first;
        names.forEach(name=>{const field=form.elements[name];field.value=field.value.trim();if(!validate(field)&&!first)first=field;});
        summary.hidden=!first;
        if(first){event.preventDefault();first.focus();return;}
        sending=true;submit.disabled=true;submit.querySelector('span').textContent='Sending…';form.setAttribute('aria-busy','true');
    });
    window.addEventListener('pageshow',()=>{sending=false;submit.disabled=false;submit.querySelector('span').textContent=label;form.removeAttribute('aria-busy');});
})();