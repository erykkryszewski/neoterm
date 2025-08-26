<?php

// design provides tel/mail field which is not in cf7, below there is mega giga custom validation

add_filter('wpcf7_validate_text*', 'validate_contact_like_fields', 10, 2);
add_filter('wpcf7_validate_text', 'validate_contact_like_fields', 10, 2);
function validate_contact_like_fields($result, $tag)
{
  $names = ['contact', 'your-contact'];
  if (!in_array($tag->name, $names, true)) {
    return $result;
  }
  $key = $tag->name;
  $value = isset($_POST[$key]) ? trim((string) $_POST[$key]) : '';
  if ($value === '') {
    return $result;
  }
  if (filter_var($value, FILTER_VALIDATE_EMAIL)) {
    return $result;
  }
  $digits = preg_replace('/[\s\-\(\)\.\,]/', '', $value);
  if (preg_match('/^\+?[0-9]{7,15}$/', $digits)) {
    return $result;
  }
  $result->invalidate($tag, 'Podaj poprawny numer telefonu lub adres email.');
  return $result;
}
