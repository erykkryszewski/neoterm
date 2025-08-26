<?php
$url = 'http://' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
$section_id = get_field('section_id');
$background = get_field('background');
$content = get_field('content');
$image = get_field('image');
$button = get_field('button');
?>

<div class="homepage-hero">
  <?php if (!empty($section_id)): ?>
  <div class="section-id" id="<?php echo esc_html($section_id); ?>"></div>
  <?php endif; ?>
  <div class="container-fluid container-fluid--padding">
    <div class="row homepage-hero__row">
      <div class="col-12 col-md-6">
        <div class="homepage-hero__content">
          <?php if (!empty($content)): ?>
          <?php echo apply_filters('acf_the_content', str_replace('&nbsp;', ' ', $content)); ?>
          <?php endif; ?>
          <?php if (!empty($button)): ?>
          <a href="<?php echo esc_html($button['url']); ?>" class="button button--arrow homepage-hero__button"
            target="<?php echo esc_html($button['target']); ?>"><?php echo esc_html($button['title']); ?>
            <span class="animation"></span></a>
          <?php endif; ?>
        </div>
      </div>
      <?php if (!empty($image)): ?>
      <div class="col-12 col-md-6">
        <div class="homepage-hero__picture">
          <?php echo wp_get_attachment_image($image, 'full', '', ['class' => 'object-fit-cover']); ?>
        </div>
      </div>
      <?php endif; ?>
    </div>
  </div>
</div>