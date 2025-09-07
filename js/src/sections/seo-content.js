document.addEventListener('DOMContentLoaded', function () {
  if (document.querySelector('.seo-tags')) {
    document.querySelector('main').classList.add('main--seo-page');
    document.querySelectorAll('.container').forEach(function (container) {
      container.classList.add('narrow');
    });
  }
});
