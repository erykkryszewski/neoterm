<?php

$url = 'http://' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
$section_id = get_field('section_id');
$background = get_field('background');

$title = get_field('title');
$icon = get_field('icon');
$text = get_field('text');
$button = get_field('button');

$form_text = get_field('form_text');
$form_shortcode = get_field('form_shortcode');
?>


<?php if (!empty($title) || !empty($icon) || !empty($text) || !empty($button) || !empty($form_text)): ?>
<div class="cta">
  <?php if (!empty($section_id)): ?>
  <div class="section-id" id="<?php echo esc_html($section_id); ?>"></div>
  <?php endif; ?>

  <div class="container">
    <div class="cta__wrapper">
      <div class="row">
        <div class="col-md-6">
          <div class="cta__column cta__column--left">
            <div class="cta__box">
              <div class="cta__intro">
                <?php if (!empty($icon)): ?>
                <div class="cta__icon">
                  <?php echo wp_get_attachment_image($icon, 'large', '', ['class' => '']); ?>
                </div>
                <?php endif; ?>
                <?php if (!empty($title)): ?>
                <h3 class="cta__title">
                  <?php echo apply_filters('the_title', $title); ?>
                </h3>
                <?php endif; ?>
              </div>
              <?php if (!empty($text)): ?>
              <div class="cta__text">
                <?php echo apply_filters('acf_the_content', $text); ?>
              </div>
              <?php endif; ?>
              <?php if (!empty($button)): ?>
              <a href="<?php echo esc_html($button['url']); ?>"
                class="button button--phone button--w-100 cta__button"><?php echo esc_html($button['title']); ?></a>
              <?php endif; ?>
            </div>
          </div>
        </div>
        <div class="col-md-6">
          <div class="cta__column cta__column--right">
            <?php if (!empty($form_text)): ?>
            <div class="cta__form-text">
              <?php echo apply_filters('acf_the_content', $form_text); ?>
            </div>
            <?php endif; ?>
            <?php if (!empty($form_shortcode)): ?>
            <div class="cta__form">
              <?php echo do_shortcode($form_shortcode); ?>
              <button class="button button--arrow" id="cf7-form-submit">Wyślij <span class="animation"></span></button>
            </div>
            <?php endif; ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php endif; ?>
