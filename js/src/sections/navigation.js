import $ from 'jquery';

// mobile navigation, jQuery style, done in 2019 :D

$('document').ready(function () {
  $('.hamburger').on('click', function () {
    $(this).toggleClass('active');
    $('.header').toggleClass('header--open');
    $('.nav').toggleClass('nav--open');
    $('.nav__menu').toggleClass('nav__menu--open');
    $('.nav .sub-menu').toggleClass('sub-menu--open');
    $('.nav__button').toggleClass('nav__button--open');
    $('.nav__hamburger').toggleClass('nav__hamburger--open');
    $('.nav__menu').slideToggle();
  });

  $('.menu-item-has-children > a').on('click', function (e) {
    e.preventDefault();
    if (window.matchMedia('(max-width: 1199px)').matches) {
      var $submenu = $(this).siblings('ul');
      $submenu.stop(true, true).slideToggle(250);
    }
  });

  // Reset navigation styles on window resize
  $(window).resize(function () {
    if ($(window).width() > 1199) {
      // Reset the styles affected by slideToggle
      $('.nav__menu').removeAttr('style');
      $('.menu-item-has-children > ul').removeAttr('style');

      // Remove classes added for mobile view
      $('.hamburger').removeClass('active');
      $('.header').removeClass('header--open');
      $('.nav').removeClass('nav--open');
      $('.nav__menu').removeClass('nav__menu--open');
      $('.nav .sub-menu').removeClass('sub-menu--open');
      $('.nav__button').removeClass('nav__button--open');
      $('.nav__hamburger').removeClass('nav__hamburger--open');
      $('.nav__button.nav__button--shop').fadeOut();
    }
  });

  // additional button stuff

  setTimeout(function () {
    if (window.matchMedia('(max-width: 1199px)').matches) {
      var btn = $('.nav__button.nav__button--shop');
      if (btn.length && !$('.nav__menu .nav__button--shop').length) {
        $('.nav__menu').append(btn);
        btn.fadeIn();
      }
    }
  }, 1000);
});
