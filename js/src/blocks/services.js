window.addEventListener('DOMContentLoaded', () => {
  const sliders = document.querySelectorAll('.services__slider');
  if (!sliders.length) return;

  const waitForImages = (root) => {
    const imgs = Array.from(root.querySelectorAll('img'));
    if (!imgs.length) return Promise.resolve();
    return Promise.all(
      imgs.map((img) => {
        if (img.decode) return img.decode().catch(() => {});
        if (img.complete) return Promise.resolve();
        return new Promise((res) => {
          img.addEventListener('load', res, { once: true });
          img.addEventListener('error', res, { once: true });
        });
      }),
    );
  };

  const waitForFonts = () => {
    if (document.fonts && document.fonts.ready) return document.fonts.ready.catch(() => {});
    return Promise.resolve();
  };

  const init = async (slider) => {
    let track = slider.querySelector('.services__track');
    if (!track) {
      track = document.createElement('div');
      track.className = 'services__track';
      const kids = Array.from(slider.children);
      kids.forEach((n) => track.appendChild(n));
      slider.appendChild(track);
    }

    await Promise.all([waitForImages(track), waitForFonts()]);

    const cs = getComputedStyle(track);
    const gap = parseFloat(cs.columnGap || cs.gap || '0') || 0;

    const speed = parseFloat(slider.getAttribute('data-speed') || '120');
    let x = 0;
    let last = performance.now();

    if (track._raf) cancelAnimationFrame(track._raf);

    const step = (now) => {
      const dt = Math.min((now - last) / 1000, 1 / 60);
      last = now;

      x -= speed * dt;

      let first = track.firstElementChild;
      let w = (first ? first.getBoundingClientRect().width : 0) + gap;

      while (first && -x >= w) {
        track.appendChild(first);
        x += w;
        first = track.firstElementChild;
        w = (first ? first.getBoundingClientRect().width : 0) + gap;
      }

      track.style.transform = `translate3d(${x}px,0,0)`;
      track._raf = requestAnimationFrame(step);
    };

    track._raf = requestAnimationFrame(step);

    let to;
    const onResize = () => {
      cancelAnimationFrame(track._raf);
      clearTimeout(to);
      to = setTimeout(() => init(slider), 150);
    };
    window.addEventListener('resize', onResize, { passive: true });
  };

  sliders.forEach(init);
});
