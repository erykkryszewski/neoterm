window.addEventListener('DOMContentLoaded', () => {
  const tracks = document.querySelectorAll('.logos__items');
  if (!tracks.length) return;

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

  const initTrack = async (track) => {
    const viewport = track.closest('.logos__viewport') || track.parentElement;
    if (!viewport) return;

    const baseHTML = track.dataset.base || track.innerHTML;
    track.dataset.base = baseHTML;
    track.innerHTML = baseHTML;

    await waitForImages(track);

    const cs = getComputedStyle(track);
    const gap = parseFloat(cs.columnGap || cs.gap || '0') || 0;

    const widthOf = (el) => el.getBoundingClientRect().width;
    const measureTotal = () => {
      const kids = Array.from(track.children);
      const kidsWidth = kids.reduce((s, el) => s + widthOf(el), 0);
      return kidsWidth + gap * Math.max(0, kids.length - 1);
    };

    const vw = viewport.getBoundingClientRect().width;
    while (measureTotal() < vw * 2) {
      track.insertAdjacentHTML('beforeend', baseHTML);
    }

    let widths = Array.from(track.children, widthOf);

    // animation
    const speed = parseFloat(track.getAttribute('data-speed') || '140');
    let x = 0;
    let head = 0;
    let last = performance.now();

    if (track._raf) cancelAnimationFrame(track._raf);

    const step = (now) => {
      const dt = Math.min((now - last) / 1000, 1 / 30);
      last = now;
      x -= speed * dt;

      let w = widths[head] + gap;

      while (-x >= w) {
        track.appendChild(track.firstElementChild);
        x += w;
        head = (head + 1) % widths.length;
        w = widths[head] + gap;
      }

      track.style.transform = `translate3d(${x}px,0,0)`;
      track._raf = requestAnimationFrame(step);
    };

    track._raf = requestAnimationFrame(step);

    let t;
    const onResize = () => {
      cancelAnimationFrame(track._raf);
      clearTimeout(t);
      t = setTimeout(() => initTrack(track), 150);
    };
    window.addEventListener('resize', onResize, { passive: true });
  };

  tracks.forEach(initTrack);
});
