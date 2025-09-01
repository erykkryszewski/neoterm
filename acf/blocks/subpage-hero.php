<?php
$url = 'http://' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
$section_id = get_field('section_id');
$background = get_field('background');
$title = get_field('title');
$text = get_field('text');
$button = get_field('button');
?>

<div class="subpage-hero">
  <?php if (!empty($section_id)): ?>
  <div class="section-id" id="<?php echo esc_html($section_id); ?>"></div>
  <?php endif; ?>
  <div class="container">
    <div class="subpage-hero__wrapper">
      <div class="row">
        <?php if (!empty($title) || !empty($button)): ?>
        <div class="col-lg-6">
          <div class="subpage-hero__column subpage-hero__column--left">
            <h1 class="subpage-hero__title"><?php echo apply_filters('the_title', $title); ?></h1>
            <?php if (!empty($button)): ?>
            <a href="<?php echo esc_url_raw($button['url']); ?>"
              class="button button--arrow"><?php echo esc_html($button['title']); ?></a>
            <?php endif; ?>
          </div>
        </div>
        <?php endif; ?>
        <?php if (!empty($text)): ?>
        <div class="col-lg-6">
          <div class="subpage-hero__column subpage-hero__column--right">
            <?php echo apply_filters('acf_the_content', $text); ?>
          </div>
        </div>
        <?php endif; ?>
      </div>
    </div>
  </div>
</div>