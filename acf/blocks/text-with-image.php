<?php
$url = 'http://' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
$section_id = get_field('section_id');
$background = get_field('background');
$title = get_field('title');
$text = get_field('text');
$labels = get_field('labels');
$image = get_field('image');
$image_class = get_field('image_class');
$direction = get_field('direction');
$button = get_field('button');
?>

<div class="text-with-image <?php if ('true' == $background) {
  echo 'text-with-image--background';
} ?>">
  <?php if (!empty($section_id)): ?>
  <div class="section-id" id="<?php echo esc_html($section_id); ?>"></div>
  <?php endif; ?>
  <div class="container">
    <div class="row text-with-image__row <?php if ('reverse' == $direction) {
      echo 'text-with-image__row--reverse';
    } ?>">
      <div class="col-12 col-md-6">
        <?php if (!empty($title)): ?>
        <h2 class="text-with-image__title"><?php echo apply_filters('the_title', $title); ?></h2>
        <?php endif; ?>
        <div>
          <?php echo apply_filters('acf_the_content', str_replace('&nbsp;', ' ', $text)); ?>
        </div>
        <?php if (!empty($labels)): ?>
        <ul class="text-with-image__labels">
          <?php foreach ($labels as $item): ?>
          <li class="text-with-image__label">
            <?php if (!empty($item['link'])): ?>
            <a href="<?php echo esc_html($item['link']['url']); ?>"><?php echo esc_html($item['link']['title']); ?></a>
            <?php else: ?>
            <?php echo esc_html($item['text']); ?>
            <?php endif; ?>
          </li>
          <?php endforeach; ?>
        </ul>
        <?php endif; ?>
        <?php if (!empty($button)): ?>
        <a href="<?php echo esc_html($button['url']); ?>" class="arrow-link text-with-image__link"
          target="<?php echo esc_html($button['target']); ?>"><?php echo esc_html($button['title']); ?></a>
        <?php endif; ?>
      </div>
      <?php if (!empty($image)): ?>
      <div class="col-12 col-md-6">
        <div class="text-with-image__picture <?php if ('reverse' == $direction) {
          echo 'text-with-image__picture--reverse';
        } ?>">

          <?php echo wp_get_attachment_image($image, 'full', '', ['class' => 'object-fit-cover']); ?>

        </div>
      </div>
      <?php endif; ?>
    </div>
  </div>
</div>