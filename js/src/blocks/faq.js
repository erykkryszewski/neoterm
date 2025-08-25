import $ from 'jquery';

$(document).ready(function () {
  $('.faq__header').on('click', function () {
    var item = $(this).closest('.faq__item');
    var panel = item.find('.faq__panel');

    if (item.hasClass('is-open')) {
      item.removeClass('is-open');
      $(this).attr('aria-expanded', 'false');
      panel.slideUp(200, function () {
        panel.attr('hidden', true);
      });
    } else {
      var openItems = item.siblings('.is-open');
      openItems.removeClass('is-open').find('.faq__header').attr('aria-expanded', 'false');
      openItems.find('.faq__panel').slideUp(200, function () {
        $(this).attr('hidden', true);
      });

      item.addClass('is-open');
      $(this).attr('aria-expanded', 'true');
      panel.attr('hidden', false).hide().slideDown(200);
    }
  });
});
