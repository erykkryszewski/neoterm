import $ from 'jquery';
import { gsap } from 'gsap';
import { ScrollTrigger } from 'gsap/ScrollTrigger';

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

  const init = async (sliderElement) => {
    let trackElement = sliderElement.querySelector('.services__track');
    if (!trackElement) {
      trackElement = document.createElement('div');
      trackElement.className = 'services__track';
      const children = Array.from(sliderElement.children);
      children.forEach(function (node) {
        trackElement.appendChild(node);
      });
      sliderElement.appendChild(trackElement);
    }

    const baseHtmlString = trackElement.dataset.base || trackElement.innerHTML;
    trackElement.dataset.base = baseHtmlString;
    trackElement.innerHTML = baseHtmlString;

    await Promise.all([waitForImages(trackElement), waitForFonts()]);

    const computedStyle = getComputedStyle(trackElement);
    const gapValue = parseFloat(computedStyle.columnGap || computedStyle.gap || '0') || 0;

    const widthOfElement = function (el) {
      return el.getBoundingClientRect().width;
    };

    const measureTotalWidth = function () {
      const items = Array.from(trackElement.children);
      const itemsWidth = items.reduce(function (sum, el) {
        return sum + widthOfElement(el);
      }, 0);
      return itemsWidth + gapValue * Math.max(0, items.length - 1);
    };

    const viewportWidth = sliderElement.getBoundingClientRect().width;
    while (measureTotalWidth() < viewportWidth * 2) {
      trackElement.insertAdjacentHTML('beforeend', baseHtmlString);
    }

    let widthsArray = Array.from(trackElement.children, widthOfElement);

    const baseSpeedValue = parseFloat(sliderElement.getAttribute('data-speed') || '120');
    let speedValue = baseSpeedValue;
    if (window.matchMedia('(max-width: 991px)').matches) {
      speedValue = baseSpeedValue * 0.6;
    }

    let translateX = 0;
    let headIndex = 0;
    let lastTime = performance.now();

    if (trackElement._raf) cancelAnimationFrame(trackElement._raf);

    const step = function (now) {
      const delta = Math.min((now - lastTime) / 1000, 1 / 30);
      lastTime = now;

      translateX -= speedValue * delta;

      let distance = widthsArray[headIndex] + gapValue;
      while (-translateX >= distance) {
        trackElement.appendChild(trackElement.firstElementChild);
        translateX += distance;
        headIndex = (headIndex + 1) % widthsArray.length;
        distance = widthsArray[headIndex] + gapValue;
      }

      trackElement.style.transform = 'translate3d(' + translateX + 'px,0,0)';
      trackElement._raf = requestAnimationFrame(step);
    };

    trackElement._raf = requestAnimationFrame(step);

    let resizeTimer;
    const onResize = function () {
      cancelAnimationFrame(trackElement._raf);
      clearTimeout(resizeTimer);
      resizeTimer = setTimeout(function () {
        init(sliderElement);
      }, 150);
    };
    window.addEventListener('resize', onResize, { passive: true });
  };

  sliders.forEach(init);

  //gsap animation

  const servicesSections = document.querySelectorAll('.services');
  if (servicesSections.length) {
    servicesSections.forEach((sec) => {
      const tl = gsap.timeline({
        scrollTrigger: {
          trigger: sec,
          start: 'top 75%',
          once: true,
        },
      });
      const title = sec.querySelector('.services__title');
      const boxes = sec.querySelectorAll('.services__box');
      if (title) tl.from(title, { y: 20, autoAlpha: 0, duration: 0.6, ease: 'power2.out' });
      if (boxes.length)
        tl.from(boxes, { y: 24, autoAlpha: 0, duration: 0.6, ease: 'power2.out', stagger: 0.08 }, '-=0.2');

      const slider = sec.querySelector('.services__slider');
      if (slider) {
        gsap.from(slider, {
          scrollTrigger: { trigger: slider, start: 'top 80%', once: true },
          y: 20,
          autoAlpha: 0,
          duration: 0.6,
          ease: 'power2.out',
        });
      }
    });
  }
});
