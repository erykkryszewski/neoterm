import $ from 'jquery';

document.addEventListener('DOMContentLoaded', function () {
  var content = document.querySelector('.single-blog-post__content');
  if (content) {
    var containers = content.querySelectorAll('.container');
    for (var i = 0; i < containers.length; i++) {
      var links = containers[i].querySelectorAll('a[href]');
      for (var j = 0; j < links.length; j++) {
        if (!links[j].classList.contains('arrow-link')) {
          links[j].classList.add('arrow-link');
        }
      }
    }
  }

  var $carousel = $('.theme-blog__carousel');
  var $rail = $('.theme-blog__carousel-rail');

  if ($carousel.length && !$carousel.hasClass('slick-initialized')) {
    $carousel.slick({
      mobileFirst: true,
      slidesToShow: 1,
      slidesToScroll: 1,
      infinite: false,
      dots: false,
      arrows: true,
      prevArrow: '<button type="button" class="slick-prev" aria-label="Poprzedni"></button>',
      nextArrow: '<button type="button" class="slick-next" aria-label="Następny"></button>',
      appendArrows: $rail.length ? $rail : undefined,
      speed: 350,
      cssEase: 'ease',
      adaptiveHeight: false,
      variableWidth: false,
      centerMode: false,
      responsive: [{ breakpoint: 1200, settings: { slidesToShow: 3 } }],
    });
  }
});
