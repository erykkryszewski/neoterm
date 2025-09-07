import $ from 'jquery';

document.addEventListener('DOMContentLoaded', function () {
  const content = document.querySelector('.single-blog-post__content');
  if (content) {
    const containers = content.querySelectorAll('.container');
    for (let i = 0; i < containers.length; i++) {
      const links = containers[i].querySelectorAll('a[href]');
      for (let j = 0; j < links.length; j++) {
        if (!links[j].classList.contains('arrow-link')) links[j].classList.add('arrow-link');
      }
    }
  }

  const $carousel = $('.theme-blog__carousel');
  const $rail = $('.theme-blog__carousel-rail');
  if (!$carousel.length) return;

  const mq = window.matchMedia('(max-width: 991px)');
  let mode = mq.matches ? 'mobile' : 'desktop';

  function init(modeNow) {
    const isMobile = modeNow === 'mobile';
    if ($carousel.hasClass('slick-initialized')) $carousel.slick('unslick');

    $carousel.slick({
      mobileFirst: true,
      slidesToShow: isMobile ? 1 : 3,
      slidesToScroll: 1,
      fade: isMobile ? true : false,
      infinite: false,
      dots: false,
      arrows: true,
      prevArrow: '<button type="button" class="slick-prev" aria-label="Poprzedni"></button>',
      nextArrow: '<button type="button" class="slick-next" aria-label="Następny"></button>',
      appendArrows: $rail.length ? $rail : undefined,
      speed: isMobile ? 250 : 350,
      cssEase: 'ease',
      adaptiveHeight: false,
      variableWidth: false,
      centerMode: false,
    });
  }

  init(mode);

  mq.addEventListener('change', (e) => {
    const nextMode = e.matches ? 'mobile' : 'desktop';
    if (nextMode !== mode) {
      mode = nextMode;
      init(mode);
    }
  });
});
