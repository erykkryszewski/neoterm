import $ from 'jquery';

$('document').ready(function () {
  var isNavAnimating = false;

  $('.hamburger').on('click', function () {
    if (!window.matchMedia('(max-width: 1199px)').matches) return;
    if (isNavAnimating) return;
    var $menu = $('.nav__menu');
    var willOpen = !$menu.is(':visible');
    isNavAnimating = true;

    if (willOpen) {
      $('.hamburger').addClass('active');
      $('.header').addClass('header--open');
      $('.nav').addClass('nav--open');
      $menu.addClass('nav__menu--open');
      $('.nav .sub-menu').addClass('sub-menu--open');
      $('.nav__button').addClass('nav__button--open');
      $('.nav__hamburger').addClass('nav__hamburger--open');
      $('body').addClass('overflow-hidden');
    } else {
      $('.hamburger').removeClass('active');
      $('.header').removeClass('header--open');
      $('.nav').removeClass('nav--open');
      $menu.removeClass('nav__menu--open');
      $('.nav .sub-menu').removeClass('sub-menu--open');
      $('.nav__button').removeClass('nav__button--open');
      $('.nav__hamburger').removeClass('nav__hamburger--open');
      $('body').removeClass('overflow-hidden');
    }

    $menu.stop(true, false).slideToggle(250, function () {
      isNavAnimating = false;
    });
  });

  $('.menu-item-has-children > a').on('click', function (e) {
    e.preventDefault();
    if (!window.matchMedia('(max-width: 1199px)').matches) return;
    var $submenu = $(this).siblings('ul');
    if ($submenu.data('isAnimating')) return;
    $submenu.data('isAnimating', true);
    $submenu.stop(true, false).slideToggle(250, function () {
      $submenu.data('isAnimating', false);
    });
  });

  $(window).resize(function () {
    if ($(window).width() > 1199) {
      $('.nav__menu').stop(true, true).removeAttr('style').removeClass('nav__menu--open');
      $('.menu-item-has-children > ul').each(function () {
        $(this).stop(true, true).removeAttr('style').data('isAnimating', false);
      });
      $('.hamburger').removeClass('active');
      $('.header').removeClass('header--open');
      $('.nav').removeClass('nav--open');
      $('.nav .sub-menu').removeClass('sub-menu--open');
      $('.nav__button').removeClass('nav__button--open');
      $('.nav__hamburger').removeClass('nav__hamburger--open');
      $('.nav__button.nav__button--shop').fadeOut();
      isNavAnimating = false;
    }
  });

  setTimeout(function () {
    if (window.matchMedia('(max-width: 1199px)').matches) {
      var $shopButton = $('.nav__button.nav__button--shop');
      if ($shopButton.length && !$('.nav__menu .nav__button--shop').length) {
        $('.nav__menu').append($shopButton);
        $shopButton.fadeIn();
      }
    }
  }, 1000);
});
