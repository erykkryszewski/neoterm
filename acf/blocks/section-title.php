<?php
$url = 'http://' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
$section_id = get_field('section_id');
$background = get_field('background');
$title = get_field('title');
$decoration_text = get_field('decoration_text');
$text = get_field('text');
$centered = get_field('centered');
?>

<div class="section-title <?php if ($background == 'true') {
  echo 'section-title--background';
} ?>" id="section-<?php echo esc_html($section_id); ?>">
  <?php if (!empty($section_id)): ?>
  <div class="section-id <?php if ($background == 'true') {
    echo 'section-id--background';
  } ?>" id="<?php echo esc_html($section_id); ?>"></div>
  <?php endif; ?>
  <div class="container">
    <div class="section-title__wrapper <?php if ($centered == 'true') {
      echo 'section-title__wrapper--centered';
    } else {
      echo 'section-title__wrapper--decorated';
    } ?>">
      <?php if (!empty($title)): ?>
      <?php if (!empty($decoration_text)): ?>
      <span class="section-title__decoration-text"><?php echo esc_html($decoration_text); ?></span>
      <?php endif; ?>
      <h2 class="section-title__title"><?php echo apply_filters('the_title', $title); ?></h2>
      <?php endif; ?>
      <?php if (!empty($text)): ?>
      <?php echo apply_filters('acf_the_content', str_replace('&nbsp;', ' ', $text)); ?>
      <?php endif; ?>
    </div>
  </div>
</div>