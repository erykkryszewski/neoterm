document.addEventListener('DOMContentLoaded', function () {
  const wrappers = document.querySelectorAll('.contact__form');
  wrappers.forEach(function (wrapper) {
    const form = wrapper.querySelector('form.wpcf7-form');
    const customBtn = wrapper.querySelector('#cf7-form-submit') || wrapper.querySelector('.button--arrow');
    const realSubmit = form ? form.querySelector('input.wpcf7-submit[type="submit"]') : null;
    if (!form || !customBtn || !realSubmit) return;
    customBtn.addEventListener('click', function (e) {
      e.preventDefault();
      customBtn.disabled = true;
      if (typeof form.requestSubmit === 'function') {
        form.requestSubmit(realSubmit);
      } else {
        realSubmit.click();
      }
    });
    const enable = function (ev) {
      if (ev.target === form) customBtn.disabled = false;
    };
    ['wpcf7invalid', 'wpcf7mailsent', 'wpcf7mailfailed', 'wpcf7spam', 'wpcf7submit', 'wpcf7reset'].forEach(
      function (evt) {
        document.addEventListener(evt, enable, false);
      },
    );
  });
});
