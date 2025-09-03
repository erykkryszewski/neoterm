import $ from 'jquery';

$(document).ready(function () {
  var navLock = false;

  function openMenu() {
    $('.hamburger').addClass('active');
    $('.header').addClass('header--open');
    $('body').addClass('overflow-hidden');
    $('.nav').addClass('nav--open');
    $('.nav__menu').addClass('nav__menu--open display-flex').removeAttr('style');
    $('.nav__button').addClass('nav__button--open');
    $('.nav__hamburger').addClass('nav__hamburger--open');
    $('.menu-item-has-children > ul').stop(true, true).hide();
  }

  function closeMenu() {
    $('.hamburger').removeClass('active');
    $('.header').removeClass('header--open');
    $('body').removeClass('overflow-hidden');
    $('.nav').removeClass('nav--open');
    $('.nav__menu').removeClass('nav__menu--open display-flex').removeAttr('style');
    $('.nav__button').removeClass('nav__button--open');
    $('.nav__hamburger').removeClass('nav__hamburger--open');
    $('.menu-item-has-children > ul').stop(true, true).hide().removeAttr('style');
  }

  $('.hamburger').on('click', function () {
    if (navLock) return;
    navLock = true;
    var isOpen = $('.nav__menu').hasClass('nav__menu--open');
    if (isOpen) {
      closeMenu();
    } else {
      openMenu();
    }
    setTimeout(function () {
      navLock = false;
    }, 350);
  });

  $('.menu-item-has-children > a').on('click', function (e) {
    if (window.matchMedia('(max-width: 1199px)').matches) {
      e.preventDefault();
      $(this).siblings('ul').stop(true, true).slideToggle(250);
    }
  });

  $('.nav__menu li > a').on('click', function () {
    if (window.matchMedia('(max-width: 1199px)').matches && !$(this).parent().hasClass('menu-item-has-children')) {
      closeMenu();
    }
  });

  $(window).on('resize', function () {
    if ($(window).width() > 1199) {
      closeMenu();
      $('.menu-item-has-children > ul').removeAttr('style');
    }
  });

  setTimeout(function () {
    if (window.matchMedia('(max-width: 1199px)').matches) {
      var btn = $('.nav__button.nav__button--shop');
      if (btn.length && !$('.nav__menu .nav__button--shop').length) {
        $('.nav__menu').append(btn);
        btn.css('display', 'flex');
      }
    }
  }, 1000);
});
