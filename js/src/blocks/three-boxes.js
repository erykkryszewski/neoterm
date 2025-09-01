import $ from 'jquery';

$(window).scroll(function () {
  $('.numbers__wrapper').each(function (index, element) {
    let $wrapper = $(element);
    let oTop1 = $wrapper.offset().top - window.innerHeight;

    if (!$wrapper.data('animated') && $(window).scrollTop() > oTop1) {
      $wrapper.find('.numbers__digit').each(function () {
        let $this = $(this);
        let raw = $this.attr('data-count') || $this.text();
        let parts = extractNumberParts(raw);
        if (!parts) return;

        let start = 0;
        let target = parts.value;

        $({ countNum: start }).animate(
          { countNum: target },
          {
            duration: 2000,
            easing: 'swing',
            step: function () {
              let out = formatOutput(Number(this.countNum), parts);
              $this.text(out);
            },
            complete: function () {
              let out = formatOutput(target, parts);
              $this.text(out);
            },
          },
        );

        $this.css('opacity', '1');
      });

      $wrapper.data('animated', true);
    }
  });
});

function extractNumberParts(str) {
  let m = String(str).match(/\d+(?:[.,]\d+)?/);
  if (!m) return null;
  let idx = m.index;
  let numStr = m[0];
  let prefix = str.slice(0, idx);
  let suffix = str.slice(idx + numStr.length);
  let decimals = 0;
  let sep = '.';
  if (numStr.includes(',')) {
    sep = ',';
    decimals = numStr.split(',')[1] ? numStr.split(',')[1].length : 0;
  } else if (numStr.includes('.')) {
    sep = '.';
    decimals = numStr.split('.')[1] ? numStr.split('.')[1].length : 0;
  }
  let value = parseFloat(numStr.replace(',', '.'));
  return { prefix, suffix, sep, decimals, value };
}

function formatOutput(value, parts) {
  let v = parts.decimals > 0 ? Number(value).toFixed(parts.decimals) : Math.floor(Number(value)).toString();
  if (parts.decimals > 0) {
    let split = v.split('.');
    let intPart = formatFiveDigit(split[0]);
    let fracPart = split[1];
    v = intPart + (parts.sep === ',' ? ',' : '.') + fracPart;
  } else {
    v = formatFiveDigit(v);
  }
  if (parts.sep === ',') v = v.replace('.', ',');
  return parts.prefix + v + parts.suffix;
}

function formatFiveDigit(numStr) {
  return numStr.length === 5 ? numStr.replace(/(\d{2})(\d{3})/, '$1 $2') : numStr;
}
