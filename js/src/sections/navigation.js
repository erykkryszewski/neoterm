import $ from 'jquery';

$('document').ready(function () {
  let isNavAnimating = false;

  function applyStaggerIndexes() {
    const menuRoot = document.querySelector('.nav__menu');
    if (!menuRoot) return;

    const topLevelItems = menuRoot.querySelectorAll(':scope > li');
    topLevelItems.forEach(function (el, idx) {
      el.style.setProperty('--i', idx);
    });

    const allSubmenus = menuRoot.querySelectorAll(':scope > li > ul.sub-menu');
    allSubmenus.forEach(function (ul) {
      const submenuItems = ul.querySelectorAll(':scope > li');
      submenuItems.forEach(function (li, idx) {
        li.style.setProperty('--i', idx);
      });
    });
  }

  $('.hamburger').on('click', function () {
    if (!window.matchMedia('(max-width: 1199px)').matches) return;
    if (isNavAnimating) return;

    const $menuElement = $('.nav__menu');
    const willOpenMenu = !$menuElement.hasClass('nav__menu--open');
    isNavAnimating = true;

    if (willOpenMenu) {
      $('.hamburger').addClass('active');
      $('.header').addClass('header--open');
      $('.nav').addClass('nav--open');
      $menuElement.addClass('nav__menu--open');
      $('.nav .sub-menu').addClass('sub-menu--open');
      $('.nav__button').addClass('nav__button--open');
      $('.nav__hamburger').addClass('nav__hamburger--open');
      $('body').addClass('overflow-hidden');
    } else {
      $('.hamburger').removeClass('active');
      $('.header').removeClass('header--open');
      $('.nav').removeClass('nav--open');
      $menuElement.removeClass('nav__menu--open');
      $('.nav .sub-menu').removeClass('sub-menu--open is-open');
      $('.nav__button').removeClass('nav__button--open');
      $('.nav__hamburger').removeClass('nav__hamburger--open');
      $('body').removeClass('overflow-hidden');
    }

    applyStaggerIndexes();

    const animationDuration = 420;
    setTimeout(function () {
      isNavAnimating = false;
    }, animationDuration);
  });

  $('.menu-item-has-children > a').on('click', function (e) {
    e.preventDefault();
    if (!window.matchMedia('(max-width: 1199px)').matches) return;

    const $submenuElement = $(this).siblings('ul');
    if ($submenuElement.data('isAnimating')) return;

    const willOpen = !$submenuElement.hasClass('is-open');
    $submenuElement.data('isAnimating', true);

    if (willOpen) {
      $submenuElement.addClass('is-open');
    } else {
      $submenuElement.removeClass('is-open');
    }

    applyStaggerIndexes();

    setTimeout(function () {
      $submenuElement.data('isAnimating', false);
    }, 380);
  });

  $('.nav__menu > li').each(function () {
    let hideTimeout;

    $(this).on('mouseenter', function () {
      clearTimeout(hideTimeout);
      $(this).children('ul.sub-menu').addClass('submenu-show');
    });

    $(this).on('mouseleave', function () {
      const $submenu = $(this).children('ul.sub-menu');
      hideTimeout = setTimeout(function () {
        $submenu.removeClass('submenu-show');
      }, 200);
    });
  });

  $(window).resize(function () {
    if ($(window).width() > 1199) {
      $('.nav__menu').removeClass('nav__menu--open').removeAttr('style');
      $('.menu-item-has-children > ul').each(function () {
        $(this).removeClass('is-open').data('isAnimating', false);
      });
      $('.hamburger').removeClass('active');
      $('.header').removeClass('header--open');
      $('.nav').removeClass('nav--open');
      $('.nav .sub-menu').removeClass('sub-menu--open');
      $('.nav__button').removeClass('nav__button--open');
      $('.nav__hamburger').removeClass('nav__hamburger--open');
      $('body').removeClass('overflow-hidden');
    }
  });

  setTimeout(function () {
    if (window.matchMedia('(max-width: 1199px)').matches) {
      const $shopButton = $('.nav__button.nav__button--shop');
      if ($shopButton.length && !$('.nav__menu .nav__button--shop').length) {
        $('.nav__menu').append($shopButton);
        $shopButton.fadeIn();
        applyStaggerIndexes();
      }
    }
  }, 1000);

  applyStaggerIndexes();
});
