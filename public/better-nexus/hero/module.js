(() => {
  const orbit = document.querySelector("[data-managed-orbit]");
  const reduced = matchMedia("(prefers-reduced-motion: reduce)");
  const mobile = matchMedia("(max-width:700px)");
  const pictures = orbit
    ? [...orbit.querySelectorAll(".bn-managed-image")]
    : [];
  let frame = null,
    phase = 0,
    last = 0;
  function position() {
    if (!orbit || mobile.matches) return;
    const width = orbit.clientWidth,
      height = orbit.clientHeight;
    pictures.forEach((el, i) => {
      const a = phase + (i / pictures.length) * Math.PI * 2;
      const rx = width * 0.36,
        ry = height * 0.34;
      el.style.setProperty("--x", `${Math.cos(a) * rx}px`);
      el.style.setProperty("--y", `${Math.sin(a) * ry}px`);
    });
  }
  function animate(time) {
    if (document.hidden || mobile.matches || reduced.matches) {
      frame = null;
      last = 0;
      return;
    }
    if (last) phase += (time - last) * 0.000035;
    last = time;
    position();
    frame = requestAnimationFrame(animate);
  }
  function sync() {
    if (frame) cancelAnimationFrame(frame);
    frame = null;
    last = 0;
    position();
    if (orbit && !document.hidden && !mobile.matches && !reduced.matches)
      frame = requestAnimationFrame(animate);
  }
  if (orbit) {
    orbit.classList.toggle("bn-many-images", pictures.length > 10);
    position();
    requestAnimationFrame(() => orbit.classList.add("is-ready"));
    setTimeout(() => {
      orbit.classList.add("is-running");
      sync();
    }, 1000);
    window.addEventListener("resize", sync);
    document.addEventListener("visibilitychange", sync);
    reduced.addEventListener("change", sync);
    mobile.addEventListener("change", sync);
  }
  const video = document.querySelector("[data-hero-video]"),
    button = document.querySelector("[data-managed-motion]");
  if (video && button) {
    button.hidden = false;
    function paused() {
      video.pause();
      button.textContent = "Play background motion";
      button.setAttribute("aria-pressed", "false");
    }
    button.addEventListener("click", async () => {
      if (!video.paused) {
        paused();
        return;
      }
      try {
        await video.play();
        button.textContent = "Pause background motion";
        button.setAttribute("aria-pressed", "true");
      } catch {
        paused();
      }
    });
    document.addEventListener("visibilitychange", () => {
      if (document.hidden) paused();
    });
    reduced.addEventListener("change", () => {
      if (reduced.matches) paused();
    });
  }
})();
