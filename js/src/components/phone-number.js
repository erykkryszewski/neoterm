document.addEventListener('DOMContentLoaded', function () {
  document.querySelectorAll('.seoleadertheme-phone-number').forEach(function (seoleaderEl) {
    let seoleaderPhoneText = seoleaderEl.textContent.replace(/\D+/g, '');

    if (seoleaderPhoneText.startsWith('48') && seoleaderPhoneText.length === 11) {
      seoleaderPhoneText = `+${seoleaderPhoneText}`;
    } else if (!seoleaderPhoneText.startsWith('+48') && seoleaderPhoneText.length === 9) {
      seoleaderPhoneText = `+48${seoleaderPhoneText}`;
    }

    let match = seoleaderPhoneText.match(/^\+48(\d{3})(\d{3})(\d{3})$/);
    if (match) {
      seoleaderEl.textContent = `+48 ${match[1]} ${match[2]} ${match[3]}`;
    }
  });
});
