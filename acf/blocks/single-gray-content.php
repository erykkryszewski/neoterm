<?php

$url = 'http://' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
$background = get_field('background');
$section_id = get_field('section_id');

$button = get_field('button');
$content = get_field('content');
?>

<div class="single-gray-content">
  <?php if (!empty($section_id)): ?>
  <div class="section-id" id="<?php echo esc_html($section_id); ?>"></div>
  <?php endif; ?>
  <div class="container">
    <div class="single-gray-content__wrapper">
      <?php if (!empty($content)): ?>
      <div class="single-gray-content__content">
        <?php echo apply_filters('the_title', str_replace('&nbsp;', ' ', $content)); ?>
      </div>
      <?php endif; ?>
      <?php if (!empty($button['url'])): ?>
      <a href="<?php echo esc_html($button['url']); ?>" class="single-gray-content__link arrow-link"
        target="<?php echo esc_html($button['target']); ?>">
        <?php echo esc_html($button['title']); ?>
      </a>
      <?php endif; ?>
    </div>
  </div>
</div>