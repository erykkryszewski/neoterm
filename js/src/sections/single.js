document.addEventListener('DOMContentLoaded', function () {
  const content = document.querySelector('.single-blog-post__content');
  if (!content) return;

  const containers = content.querySelectorAll('.container');

  for (let i = 0; i < containers.length; i++) {
    let links = containers[i].querySelectorAll('a[href]');
    for (let j = 0; j < links.length; j++) {
      links[j].classList.add('arrow-link');
    }
  }
});
