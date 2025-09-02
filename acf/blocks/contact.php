<?php
$url = 'http://' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
$background = get_field('background');
$section_id = get_field('section_id');

$title = get_field('title');
$text = get_field('text');
$form_shortcode = get_field('form_shortcode');
$image = get_field('image');

$global_phone_number = get_field('global_phone_number', 'options');
$global_email = get_field('global_email', 'options');
$global_address = get_field('global_address', 'options');
$global_opening_hours = get_field('global_opening_hours', 'options');
?>

<?php if (!empty($form_shortcode)): ?>
<div class="contact">
  <?php if (!empty($section_id)): ?>
  <div class="section-id" id="<?php echo esc_html($section_id); ?>"></div>
  <?php endif; ?>
  <div class="container">
    <div class="contact__wrapper">
      <div class="contact__column contact__column--left">
        <div class="contact__intro">

          <?php if (!empty($title)): ?>
          <h1 class="contact__title"><?php echo apply_filters('the_title', str_replace('&nbsp;', ' ', $title)); ?></h1>
          <?php endif; ?>

          <?php if (!empty($text)): ?>
          <?php echo apply_filters('acf_the_content', str_replace('&nbsp;', ' ', $text)); ?>
          <?php endif; ?>

          <?php if ($global_phone_number): ?>
          <a href="tel:<?php echo esc_html($global_phone_number); ?>"
            class="button button--phone mobile-only contact__phone-button seoleadertheme-phone-number"><?php echo esc_html(
              $global_phone_number,
            ); ?></a>
          <?php endif; ?>

          <div class="contact__details">

            <?php if ($global_address): ?>
            <div>
              <span class="contact__info-text contact__info-text--address"><?php esc_html_e(
                'Adres:',
                'seoleadertheme',
              ); ?></span>
              <div class="contact__address">
                <?php echo apply_filters('the_title', $global_address); ?>
              </div>
            </div>
            <?php endif; ?>

            <?php if ($global_opening_hours): ?>
            <div>
              <span class="contact__info-text contact__info-text--opening-hours"><?php esc_html_e(
                'Godziny Otwarcia:',
                'seoleadertheme',
              ); ?></span>
              <div class="contact__opening-hours">
                <?php echo apply_filters('the_title', $global_opening_hours); ?>
              </div>
            </div>
            <?php endif; ?>


            <?php if ($global_phone_number): ?>
            <div>
              <span class="contact__info-text contact__info-text--phone"><?php esc_html_e(
                'Zadzwoń do nas:',
                'seoleadertheme',
              ); ?></span>
              <a href="tel:<?php echo esc_html($global_phone_number); ?>"
                class="contact__phone seoleadertheme-phone-number"><?php echo esc_html($global_phone_number); ?></a>
            </div>
            <?php endif; ?>


            <?php if ($global_email): ?>
            <div>
              <span class="contact__info-text contact__info-text--phone"><?php esc_html_e(
                'Email',
                'seoleadertheme',
              ); ?></span>
              <a href="mailto:<?php echo esc_html($global_email); ?>"
                class="contact__email seoleadertheme-email-number"><?php echo esc_html($global_email); ?></a>
            </div>
            <?php endif; ?>




          </div>
        </div>
      </div>
      <div class="contact__column contact__column--right">
        <?php if (!empty($form_shortcode)): ?>
        <div class="contact__form">
          <?php echo do_shortcode($form_shortcode); ?>
          <button class="button button--arrow" id="cf7-form-submit">Wyślij <span class="animation"></span></button>
        </div>
        <?php endif; ?>
      </div>
    </div>
  </div>
</div>
<?php endif; ?>
