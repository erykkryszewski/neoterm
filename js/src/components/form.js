document.addEventListener('DOMContentLoaded', function () {
  const seoleaderForm = document.querySelector('.seoleader-form');
  if (!seoleaderForm) return;
  const seoleaderFormName = document.querySelector('.seoleader-form-name');
  const seoleaderFormSurname = document.querySelector('.seoleader-form-surname');
  const seoleaderFormEmail = document.querySelector('.seoleader-form-email');
  const seoleaderFormPhone = document.querySelector('.seoleader-form-phone');
  const seoleaderFormTextarea = document.querySelector('.seoleader-form-textarea');
  const seoleaderFormAcceptance = document.querySelector('.seoleader-form-acceptance');
  const seoleaderFormSubmit = document.querySelector('input[type="submit"]');

  function seoleaderShowError(container, message) {
    if (!container) return;
    let errorEl = container.querySelector('.seoleader-error-message');
    if (!errorEl) {
      errorEl = document.createElement('div');
      errorEl.classList.add('seoleader-error-message');
      errorEl.style.color = 'red';
      errorEl.style.fontSize = '13px';
      errorEl.style.marginTop = '3px';
      errorEl.style.position = 'absolute';
      container.appendChild(errorEl);
    }
    errorEl.textContent = message;
  }

  function seoleaderRemoveError(container) {
    if (!container) return;
    const errorEl = container.querySelector('.seoleader-error-message');
    if (errorEl) errorEl.remove();
  }

  function seoleaderValidateName() {
    const input = seoleaderFormName.querySelector('input');
    input.value = input.value.replace(/[^A-Za-z\s]/g, '');
    const value = input.value.trim();
    if (value.length < 3) {
      seoleaderShowError(seoleaderFormName, 'Imię nie może być krótsze niż 3 znaki.');
      return false;
    } else {
      seoleaderRemoveError(seoleaderFormName);
      return true;
    }
  }

  function seoleaderValidateSurname() {
    const input = seoleaderFormSurname.querySelector('input');
    input.value = input.value.replace(/[^A-Za-z\s]/g, '');
    const value = input.value.trim();
    if (value.length < 3) {
      seoleaderShowError(seoleaderFormSurname, 'Nazwisko nie może być krótsze niż 3 znaki.');
      return false;
    } else {
      seoleaderRemoveError(seoleaderFormSurname);
      return true;
    }
  }

  function seoleaderValidateEmail() {
    if (!seoleaderFormEmail) return true;
    const input = seoleaderFormEmail.querySelector('input');
    const value = input ? input.value.trim() : '';
    const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!value.match(emailPattern)) {
      seoleaderShowError(seoleaderFormEmail, 'Proszę wprowadzić prawidłowy adres email.');
      return false;
    } else {
      seoleaderRemoveError(seoleaderFormEmail);
      return true;
    }
  }

  function seoleaderValidatePhone() {
    if (!seoleaderFormPhone) return true;
    const input = seoleaderFormPhone.querySelector('input');
    const value = input ? input.value.trim() : '';
    if (!/^[+0-9\s]+$/.test(value) || value.replace(/\D/g, '').length < 9) {
      seoleaderShowError(seoleaderFormPhone, 'Wprowadź prawidłowy numer telefonu.');
      return false;
    } else {
      seoleaderRemoveError(seoleaderFormPhone);
      return true;
    }
  }

  function seoleaderValidateTextarea() {
    if (!seoleaderFormTextarea) return true;
    const textarea = seoleaderFormTextarea.querySelector('textarea');
    const value = textarea ? textarea.value.trim() : '';
    if (value.length < 15) {
      seoleaderShowError(seoleaderFormTextarea, 'Wiadomość powinna mieć co najmniej 15 znaków.');
      return false;
    } else {
      seoleaderRemoveError(seoleaderFormTextarea);
      return true;
    }
  }

  function seoleaderValidateAcceptance() {
    if (!seoleaderFormAcceptance) return true;
    const checkbox = seoleaderFormAcceptance.querySelector('input[type="checkbox"]');
    if (!checkbox.checked) {
      seoleaderShowError(seoleaderFormAcceptance, 'Musisz wyrazić zgodę, aby kontynuować.');
      return false;
    } else {
      seoleaderRemoveError(seoleaderFormAcceptance);
      return true;
    }
  }

  function seoleaderValidateAllFields() {
    let valid = true;
    valid = seoleaderValidateName() && valid;
    valid = seoleaderValidateSurname() && valid;
    valid = seoleaderValidateEmail() && valid;
    valid = seoleaderValidatePhone() && valid;
    valid = seoleaderValidateTextarea() && valid;
    valid = seoleaderValidateAcceptance() && valid;
    return valid;
  }

  if (seoleaderFormName) {
    seoleaderFormName.querySelector('input').addEventListener('input', seoleaderValidateName);
  }

  if (seoleaderFormSurname) {
    seoleaderFormSurname.querySelector('input').addEventListener('input', seoleaderValidateSurname);
  }

  if (seoleaderFormEmail) {
    seoleaderFormEmail.querySelector('input').addEventListener('input', seoleaderValidateEmail);
  }

  if (seoleaderFormPhone) {
    seoleaderFormPhone.querySelector('input').addEventListener('input', seoleaderValidatePhone);
  }

  if (seoleaderFormTextarea) {
    seoleaderFormTextarea.querySelector('textarea').addEventListener('input', seoleaderValidateTextarea);
  }

  if (seoleaderFormAcceptance) {
    seoleaderFormAcceptance
      .querySelector('input[type="checkbox"]')
      .addEventListener('change', seoleaderValidateAcceptance);
  }

  if (seoleaderFormSubmit) {
    seoleaderFormSubmit.addEventListener('mouseenter', function () {
      seoleaderValidateAllFields();
    });
  }

  seoleaderForm.addEventListener('submit', function () {
    seoleaderValidateAllFields();
  });
});
