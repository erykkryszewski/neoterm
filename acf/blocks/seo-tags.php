<?php
$url = 'http://' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
$section_id = get_field('section_id');
$background = get_field('background');
$seo_tags = get_field('seo_tags');
?>

<?php if (!empty($seo_tags)): ?>
<div class="seo-tags">
  <div class="container">
    <div class="seo-tags__wrapper">
      <?php foreach ($seo_tags as $key => $item): ?>
      <?php if (!empty($item['tag']['title'])): ?>
      <a class="seo-tags__item" href="<?php echo esc_html($item['tag']['url']); ?>">
        <?php echo esc_html($item['tag']['title']); ?>
      </a>
      <?php endif; ?>
      <?php endforeach; ?>
    </div>
  </div>

</div>
<?php endif; ?>
