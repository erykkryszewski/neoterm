<?php
$url = 'http://' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
$section_id = get_field('section_id');
$background = get_field('background');
$title = get_field('title');
$text = get_field('text');
$numbers_item = get_field('numbers_item');
?>

<?php if (!empty($numbers_item)): ?>
<div class="numbers <?php if ($background == 'true') {
  echo 'numbers--background';
} ?>">
  <?php if (!empty($section_id)): ?>
  <div class="section-id" id="<?php echo esc_html($section_id); ?>"></div>
  <?php endif; ?>
  <div class="container">
    <div class="numbers__wrapper">
      <?php foreach ($numbers_item as $key => $item): ?>
      <div class="numbers__item" id="numbers__item<?php echo $key; ?>">
        <span class="numbers__digit" data-count="<?php echo esc_html($item['number']); ?>"
          id="numbers__digit<?php echo $key; ?>">000</span>
        <p class="numbers__title"><?php echo esc_html($item['title']); ?></p>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</div>
<?php endif; ?>
