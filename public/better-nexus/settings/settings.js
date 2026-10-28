(() => {
    document.querySelectorAll('[data-password-show]').forEach(button => button.addEventListener('click', () => {
        const input = document.getElementById(button.dataset.passwordShow);
        const show = input.type === 'password'; input.type = show ? 'text' : 'password';
        button.textContent = show ? 'Hide' : 'Show'; button.setAttribute('aria-pressed',String(show));
    }));
    document.querySelectorAll('[data-upload-box]').forEach(box => {
        const input=box.querySelector('[data-image-input]'),image=box.querySelector('[data-image-preview]');
        const original=image.getAttribute('src'); let url;
        input.addEventListener('change',()=>{
            if(url)URL.revokeObjectURL(url);
            const file=input.files[0];
            if(!file){image.hidden=!original;if(original)image.src=original;return;}
            url=URL.createObjectURL(file);image.src=url;image.hidden=false;
            const remove=box.querySelector('[type=checkbox]');if(remove)remove.checked=false;
        });
    });
})();