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

  var $rail = $('.theme-blog__carousel-rail');
  var $carousel = $('.theme-blog__carousel');

  if ($carousel.length) {
    $carousel.slick({
      slidesToShow: 3,
      slidesToScroll: 1,
      infinite: false,
      dots: false,
      arrows: true,
      adaptiveHeight: false,
      speed: 350,
      cssEase: 'ease',
      autoplay: false,
      centerMode: false,
      variableWidth: false,
      responsive: [{ breakpoint: 1199, settings: { slidesToShow: 1 } }],
    });
  }
});
