document.addEventListener('DOMContentLoaded', function () {
  if (window.matchMedia('(min-width: 1200px)').matches) {
    const themeBlogIntro = document.querySelector('.theme-blog__intro');
    const themeBlogSidebar = document.querySelector('.theme-blog__sidebar');
    if (themeBlogIntro && themeBlogSidebar) {
      const introHeight = themeBlogIntro.offsetHeight;
      themeBlogSidebar.style.paddingTop = introHeight + 30 + 'px';
    }
  }
});
