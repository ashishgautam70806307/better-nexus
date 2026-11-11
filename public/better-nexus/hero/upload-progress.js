(() => {
  'use strict';
  const MAX_BYTES = 100 * 1024 * 1024;
  const notice = document.querySelector('[data-global-notice]');
  const message = (node, value, error = false) => {
    if (!node) return;
    node.textContent = value;
    node.classList.toggle('is-error', error);
  };
  const showNotice = (value, error = false) => {
    if (!notice) return;
    notice.hidden = false;
    message(notice, value, error);
  };
  const csrf = () => document.querySelector('meta[name="csrf-token"]')?.content ||
    document.querySelector('.bha-video-form input[name="_token"]')?.value || '';
  const parse = (body, fallback) => {
    try {
      const data = JSON.parse(body);
      if (data.errors) return Object.values(data.errors).flat().join(' ');
      return data.message || fallback;
    } catch (_) { return fallback; }
  };

  document.querySelectorAll('form[data-ajax-video]').forEach(form => {
    const slot = form.closest('[data-video-slot]');
    if (!slot) return;
    const input = form.querySelector('input[type="file"]');
    const progress = form.querySelector('[data-upload-progress]');
    const bar = form.querySelector('[data-progress-bar]');
    const percent = form.querySelector('[data-progress-percent]');
    const label = form.querySelector('[data-progress-label]');
    const detail = form.querySelector('[data-progress-detail]');
    const cancel = form.querySelector('[data-upload-cancel]');
    const feedback = form.querySelector('[data-upload-feedback]');
    const buttons = [...form.querySelectorAll('button[type="submit"]')];
    let active = null;
    let sentAt = 0;
    const busy = (value) => { buttons.forEach(b => b.disabled = value); input.disabled = value; };
    const setProgress = (n) => {
      const pct = Math.max(0, Math.min(100, Math.round(n)));
      bar.value = pct;
      percent.textContent = `${pct}%`;
    };
    const submit = (event) => {
      event.preventDefault();
      if (active) return;
      const file = input.files?.[0];
      if (!file) return message(feedback, 'Choose an MP4 or WebM video first.', true);
      if (file.size > MAX_BYTES) return message(feedback, 'Video exceeds 100 MB. Compress it before uploading.', true);
      if (!/\.(mp4|webm)$/i.test(file.name)) return message(feedback, 'Choose an MP4 or WebM file.', true);
      const action = event.submitter?.value === 'draft' ? 'draft' : 'publish';
      const data = new FormData(form);
      data.set('publication', action); // submitter is not included in FormData(form)
      const xhr = new XMLHttpRequest();
      active = xhr;
      busy(true);
      progress.hidden = false;
      sentAt = Date.now();
      label.textContent = 'Uploading video';
      detail.textContent = `${(file.size / 1048576).toFixed(1)} MB · ${action === 'publish' ? 'Publish after upload' : 'Save as draft'}`;
      message(feedback, '');
      setProgress(0);
      xhr.open('POST', form.action);
      xhr.setRequestHeader('Accept', 'application/json');
      xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
      if (csrf()) xhr.setRequestHeader('X-CSRF-TOKEN', csrf());
      xhr.upload.addEventListener('progress', (e) => {
        if (!e.lengthComputable) {
          label.textContent = 'Uploading video...';
          return;
        }
        setProgress(e.loaded / e.total * 100);
        if (e.loaded > 0 && e.loaded < e.total) {
          const seconds = Math.max(0.25, (Date.now() - sentAt) / 1000);
          const rate = e.loaded / seconds;
          const remain = (e.total - e.loaded) / Math.max(1, rate);
          detail.textContent = `${(e.loaded / 1048576).toFixed(1)} / ${(e.total / 1048576).toFixed(1)} MB · roughly ${Math.ceil(remain)}s transfer remaining`;
        }
      });
      xhr.upload.addEventListener('load', () => {
        setProgress(100);
        label.textContent = 'Upload received — processing';
        detail.textContent = 'Server is validating, saving and updating publication. Please keep this tab open.';
        cancel.disabled = true;
      });
      const finish = () => { active = null; cancel.disabled = false; busy(false); };
      xhr.addEventListener('load', () => {
        finish();
        let response = null;
        try { response = JSON.parse(xhr.responseText); } catch (_) { /* HTML errors possible */ }
        if (xhr.status < 200 || xhr.status >= 300 || !response?.preview_url) {
          label.textContent = 'Upload failed';
          const error = xhr.status === 413 ? 'Server rejected the file size (HTTP 413). Check PHP and hosting limits.' :
            xhr.status === 419 ? 'Session expired (419). Reload admin page and sign in again.' :
            xhr.status === 429 ? 'Too many attempts (429). Retry after the rate limit resets.' :
            parse(xhr.responseText, `Upload failed (HTTP ${xhr.status || 'unknown'}).`);
          message(feedback, error, true);
          showNotice(error, true);
          return;
        }
        label.textContent = 'Upload complete';
        detail.textContent = 'Saved on server successfully.';
        const preview = slot.querySelector('[data-video-preview]');
        let video = preview?.querySelector('video');
        if (!video && preview) {
          preview.replaceChildren();
          video = document.createElement('video');
          video.controls = true;
          video.muted = true;
          video.loop = true;
          video.playsInline = true;
          video.preload = 'metadata';
          preview.append(video);
        }
        if (video) { video.pause(); video.src = response.preview_url; video.load(); }
        const status = slot.querySelector('[data-video-state]');
        if (status) {
          status.textContent = response.published ? 'Published' : 'Draft / hidden';
          status.classList.toggle('is-live', !!response.published);
          status.classList.toggle('is-draft', !response.published);
        }
        const publishBox = document.querySelector('[data-ajax-publish]');
        if (publishBox) {
          const checkbox = publishBox.querySelector(`[name="${response.device}_video_published"]`);
          if (checkbox) { checkbox.disabled = false; checkbox.checked = !!response.published; }
          if (response.active) {
            const enabled = publishBox.querySelector('[name="is_active"]');
            if (enabled) enabled.checked = true;
          }
        }
        // Existing remove form is initially omitted for an empty slot; add it by reloading only when needed.
        const remove = slot.querySelector('form[action*="/video"]:not([data-ajax-video])');
        if (!remove) {
          const hint = document.createElement('p');
          hint.className = 'bha-upload-removal-hint';
          hint.textContent = 'To remove this new upload, reload the Admin page. Uploading and publishing do not require a reload.';
          if (!slot.querySelector('.bha-upload-removal-hint')) slot.append(hint);
        }
        input.value = '';
        message(feedback, response.message || 'Video saved successfully.');
        showNotice(response.message || 'Video saved.');
      });
      xhr.addEventListener('error', () => {
        finish();
        label.textContent = 'Network error';
        message(feedback, 'Network connection failed during upload. Please retry.', true);
      });
      xhr.addEventListener('abort', () => {
        finish();
        label.textContent = 'Upload cancelled';
        message(feedback, 'Upload cancelled. Previous published video remains unchanged.');
      });
      xhr.send(data);
    };
    form.addEventListener('submit', submit);
    cancel?.addEventListener('click', () => { if (active && active.readyState !== 4) active.abort(); });
  });

  const publishForm = document.querySelector('[data-ajax-publish]');
  publishForm?.addEventListener('submit', async (event) => {
    event.preventDefault();
    const button = publishForm.querySelector('[type="submit"]');
    const feedback = publishForm.querySelector('[data-publish-feedback]');
    button.disabled = true;
    message(feedback, 'Saving publication settings...');
    try {
      const response = await fetch(publishForm.action, {
        method: 'POST', body: new FormData(publishForm), credentials: 'same-origin',
        headers: { Accept: 'application/json', 'X-Requested-With': 'XMLHttpRequest', 'X-CSRF-TOKEN': csrf() }
      });
      const body = await response.text();
      if (!response.ok) throw new Error(parse(body, `Unable to save (HTTP ${response.status}).`));
      const data = JSON.parse(body);
      for (const device of ['desktop', 'mobile']) {
        const slot = document.querySelector(`[data-video-slot="${device}"]`);
        const state = slot?.querySelector('[data-video-state]');
        const checkbox = publishForm.querySelector(`[name="${device}_video_published"]`);
        if (state && !checkbox?.disabled) {
          const published = !!data[`${device}_published`];
          state.textContent = published ? 'Published' : 'Draft / hidden';
          state.classList.toggle('is-live', published);
          state.classList.toggle('is-draft', !published);
        }
      }
      message(feedback, data.message || 'Settings saved.');
      showNotice(data.message || 'Settings saved.');
    } catch (err) {
      message(feedback, err.message || 'Failed to save.', true);
    } finally { button.disabled = false; }
  });
})();
