(() => {
  document.querySelectorAll("[data-hero-delete]").forEach((form) =>
    form.addEventListener("submit", (e) => {
      if (
        !confirm(
          "Remove this image from the homepage? Uploaded files are deleted after the record is removed.",
        )
      )
        e.preventDefault();
    }),
  );
  const input = document.querySelector("[data-hero-files]"),
    preview = document.querySelector("[data-hero-preview]");
  if (!input || !preview) return;
  let urls = [];
  input.addEventListener("change", () => {
    urls.forEach((url) => URL.revokeObjectURL(url));
    urls = [];
    preview.replaceChildren();
    const files = [...input.files];
    if (
      files.length > 8 ||
      files.some(
        (f) =>
          !["image/jpeg", "image/png", "image/webp"].includes(f.type) ||
          f.size > 4194304,
      )
    ) {
      const error = document.createElement("p");
      error.textContent =
        "Choose up to 8 JPG/PNG/WebP images, maximum 4 MB each.";
      preview.append(error);
      input.value = "";
      return;
    }
    files.forEach((file) => {
      const url = URL.createObjectURL(file);
      urls.push(url);
      const img = document.createElement("img");
      img.src = url;
      img.alt = file.name;
      preview.append(img);
    });
  });
})();
