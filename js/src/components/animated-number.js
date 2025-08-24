document.addEventListener('DOMContentLoaded', () => {
  const seoleaderAnimatedCircles = document.querySelectorAll('.animated-number__circle');

  if (!seoleaderAnimatedCircles.length) return;

  const seoleaderHandleIntersection = (entries, observer) => {
    entries.forEach((entry) => {
      if (entry.isIntersecting) {
        const target = entry.target;
        const dasharrayValue = target.getAttribute('data-dasharray');
        target.style.setProperty('--dasharray', dasharrayValue);
        target.classList.add('animated-number__circle--animated');
        observer.unobserve(target);
      }
    });
  };

  const seoleaderObserver = new IntersectionObserver(seoleaderHandleIntersection, {
    root: null,
    threshold: 0.1,
  });

  seoleaderAnimatedCircles.forEach((element) => seoleaderObserver.observe(element));
});
