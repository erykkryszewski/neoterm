import $ from 'jquery';

$(document).ready(function () {
  $('.faq__header').on('click', function () {
    var item = $(this).closest('.faq__item');
    var panel = item.find('.faq__panel');
    var answer = panel.find('.faq__answer');

    if (item.hasClass('is-open')) {
      item.removeClass('is-open');
      $(this).attr('aria-expanded', 'false');

      answer.removeClass('is-visible');
      panel.slideUp(200, function () {
        panel.attr('hidden', true);
      });
      return;
    }

    var openItems = item.siblings('.is-open');
    openItems.removeClass('is-open').find('.faq__header').attr('aria-expanded', 'false');
    openItems.each(function () {
      var $p = $(this).find('.faq__panel');
      $p.find('.faq__answer').removeClass('is-visible');
      $p.slideUp(200, function () {
        $(this).attr('hidden', true);
      });
    });

    item.addClass('is-open');
    $(this).attr('aria-expanded', 'true');

    panel
      .attr('hidden', false)
      .hide()
      .slideDown(200, function () {
        answer.removeClass('is-visible');
        if (answer[0]) answer[0].offsetHeight;
        answer.addClass('is-visible');
      });
  });
});
