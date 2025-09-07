<?php
$url = 'http://' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
$section_id = get_field('section_id');
$background = get_field('background');

$title = get_field('title');
$text = get_field('text');
$button = get_field('button');
$image = get_field('image');
$image_class = get_field('image_class');
$direction = get_field('direction');
?>

<div class="single-image-text">
  <?php if (!empty($section_id)): ?>
  <div class="section-id" id="<?php echo esc_html($section_id); ?>"></div>
  <?php endif; ?>
  <div class="container">
    <div class="single-image-text__container">

      <div class="single-image-text__wrapper">
        <?php if (!empty($image)): ?>
        <div class="single-image-text__column single-image-text__column--left">
          <div class="single-image-text__picture <?php if ('reverse' == $direction) {
            echo 'single-image-text__picture--reverse';
          } ?>">
            <?php echo wp_get_attachment_image($image, 'full', '', ['class' => 'object-fit-cover']); ?>
          </div>
        </div>
        <?php endif; ?>
        <div class="single-image-text__column single-image-text__column--right">
          <div class="single-image-text__content <?php if ('reverse' == $direction) {
            echo 'single-image-text__content--reverse';
          } ?>">
            <?php if (!empty($title)): ?>
            <h3 class="single-image-text__title"><?php echo apply_filters('the_title', $title); ?></h3>
            <?php endif; ?>
            <div class="single-image-text__text">
              <?php echo apply_filters('acf_the_content', str_replace('&nbsp;', ' ', $text)); ?>
            </div>
            <?php if (!empty($button)): ?>
            <a href="<?php echo esc_html($button['url']); ?>" class="arrow-link single-image-text__link desktop-only"
              target="<?php echo esc_html($button['target']); ?>"><?php echo esc_html($button['title']); ?></a>
            <?php endif; ?>
          </div>
        </div>
      </div>
      <div class="single-image-text__wrapper mobile-only">
        <?php if (!empty($button)): ?>
        <a href="<?php echo esc_html($button['url']); ?>"
          class="arrow-link single-image-text__link single-image-text__link--mobile"
          target="<?php echo esc_html($button['target']); ?>"><?php echo esc_html($button['title']); ?></a>
        <?php endif; ?>
      </div>

    </div>

  </div>
</div>