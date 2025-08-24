<?php

$global_phone_number = get_field('global_phone_number', 'options');
$global_logo = get_field('global_logo', 'options');
$global_email = get_field('global_email', 'options');
$global_address = get_field('global_address', 'options');
$global_social_media = get_field('global_social_media', 'options');
$newsletter_shortcode = get_field('newsletter_shortcode', 'options');
$cookies_text = get_field('cookies_text', 'options');
$google_analytics_code = get_field('google_analytics_code', 'options');

$footer_second_column_content = get_field('footer_second_column_content', 'options');
$footer_third_column_content = get_field('footer_third_column_content', 'options');
?>

<footer class="footer <?php if (is_front_page()) {
  echo 'footer--homepage';
} ?>">

</footer>

<?php if ($google_analytics_code): ?>
<?php echo wp_kses($google_analytics_code, ['script' => ['async' => [], 'src' => []]]); ?>
<?php endif; ?>

</body>

</html>
<?php wp_footer(); ?>
