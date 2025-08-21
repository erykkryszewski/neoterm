/**
 * External dependencies
 */
import $ from 'jquery';
import 'slick-carousel';
import '@fancyapps/fancybox';
// import AOS from 'aos';
// import { gsap } from "gsap";
// import { ScrollTrigger } from 'gsap/ScrollTrigger';
// import 'parallax-js';

// AOS.init();

$(window).on('load', function () {
  // AOS.refresh();
  $('.preloader').fadeOut(100);

  if ($('.products__elements').length > 0 && $(window).width() < 768) {
    $('html, body')
      .delay(200)
      .animate(
        {
          scrollTop: $('.products__elements').offset().top,
        },
        1000,
      );
  }
});

$(document).on('click', 'a[href^="#"]', function (event) {
  event.preventDefault();

  if (window.location.href.indexOf('produkt') === -1 && window.location.href.indexOf('product') === -1) {
    $('html, body').animate(
      {
        scrollTop: $($.attr(this, 'href')).offset().top,
      },
      650,
    );
  }
});

$(document).ready(function () {
  $('img[sizes^="auto,"]').each(function () {
    var $img = $(this);
    var sizes = $img.attr('sizes').replace(/^auto,\s*/, '');
    $img.attr('sizes', sizes);
  });
});

$(document).ready(function ($) {
  $('img[title]').removeAttr('title');
  $('p:empty').remove();
});

/* imports */

import './global/recaptcha';
import './global/zoom';

/* @blocks:start */
import './blocks/faq';
import './blocks/iframe';
import './blocks/logos';
/* @blocks:end */

import './sections/header';
import './sections/navigation';
import './sections/main';

import './components/spacer';
import './components/popup';
import './components/animated-number';
import './components/form';
import './components/phone-number';

import './woocommerce/archive-product';
import './woocommerce/single-product';
import './woocommerce/content-product';
import './woocommerce/cart';
import './woocommerce/checkout';
