<?php

$global_phone_number = get_field('global_phone_number', 'options');
$global_logo = get_field('global_logo', 'options');
$global_email = get_field('global_email', 'options');
$global_address = get_field('global_address', 'options');
$global_opening_hours = get_field('global_opening_hours', 'options');

$google_analytics_code = get_field('google_analytics_code', 'options');

$footer_first_column_content = get_field('footer_first_column_content', 'options');
$footer_second_column_content = get_field('footer_second_column_content', 'options');
$footer_third_column_content = get_field('footer_third_column_content', 'options');
$footer_logo = get_field('footer_logo', 'options');
$footer_logo_link = get_field('footer_logo_link', 'options');

$footer_summary = get_field('footer_summary', 'options');
$footer_attribute = get_field('footer_attribute', 'options');
?>

<footer class="footer <?php if (is_front_page()) {
  echo 'footer--homepage';
} ?>">

  <div class="container-fluid container-fluid--padding">
    <div class="footer__wrapper">
      <?php if (!empty($footer_first_column_content)): ?>
      <div class="footer__column footer__column--first">
        <?php echo apply_filters('the_content', $footer_first_column_content); ?>
      </div>
      <?php endif; ?>

      <?php if (!empty($footer_second_column_content)): ?>
      <div class="footer__column footer__column--second">
        <?php echo apply_filters('the_content', $footer_second_column_content); ?>
      </div>
      <?php endif; ?>

      <?php if (!empty($footer_third_column_content)): ?>
      <div class="footer__column footer__column--third">
        <?php echo apply_filters('the_content', $footer_third_column_content); ?>
      </div>
      <?php endif; ?>

      <div class="footer__column footer__column--fourth">
        <?php if ($footer_logo_link): ?>
        <a href="<?php echo esc_url($footer_logo_link['url']); ?>"
          target="<?php echo !empty($footer_logo_link['target']) ? esc_attr($footer_logo_link['target']) : '_self'; ?>">
          <?php if ($footer_logo): ?>
          <?php echo wp_get_attachment_image($footer_logo, 'full', false, ['class' => '']); ?>
          <?php endif; ?>
        </a>
        <?php endif; ?>

        <?php if ($global_phone_number): ?>
        <span class="footer__info-text"><?php esc_html_e('Zadzwoń do nas:', 'seoleadertheme'); ?></span>
        <a href="tel:<?php echo esc_html($global_phone_number); ?>"
          class="footer__phone seoleadertheme-phone-number"><?php echo esc_html($global_phone_number); ?></a>
        <?php endif; ?>

        <?php if ($global_address): ?>
        <span class="footer__info-text"><?php esc_html_e('Adres:', 'seoleadertheme'); ?></span>
        <div class="footer__address">
          <?php echo apply_filters('the_title', $global_address); ?>
        </div>
        <?php endif; ?>

        <?php if ($global_opening_hours): ?>
        <span class="footer__info-text"><?php esc_html_e('Godziny Otwarcia::', 'seoleadertheme'); ?></span>
        <div class="footer__opening-hours">
          <?php echo apply_filters('the_title', $global_opening_hours); ?>
        </div>
        <?php endif; ?>
      </div>
    </div>

    <?php if (!empty($footer_summary)): ?>
    <div class="footer__summary">
      <?php echo apply_filters('the_title', $footer_summary); ?>
    </div>
    <?php endif; ?>
    <?php if (!empty($footer_attribute)): ?>
    <div class="footer__attribute">
      <a href="<?php echo esc_html($footer_attribute['url']); ?>"><?php echo esc_html(
  $footer_attribute['title'],
); ?></a>
    </div>
    <?php endif; ?>
  </div>

</footer>

<?php if ($google_analytics_code): ?>
<?php echo wp_kses($google_analytics_code, ['script' => ['async' => [], 'src' => []]]); ?>
<?php endif; ?>

</body>

</html>
<?php wp_footer(); ?>
