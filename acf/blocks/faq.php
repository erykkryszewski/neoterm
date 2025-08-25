<?php
$url = 'http://' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
$background = get_field('background');
$section_id = get_field('section_id');
$faq = get_field('faq');
?>

<?php if (!empty($faq)): ?>
<div class="faq <?php if ($background == 'true') {
  echo 'faq--background';
} ?>">
  <?php if (!empty($section_id)): ?>
  <div class="section-id" id="<?php echo esc_html($section_id); ?>"></div>
  <?php endif; ?>
  <div class="container">
    <div class="faq__list">
      <?php foreach ($faq as $index => $item): ?>
      <div class="faq__item">
        <button class="faq__header" type="button" aria-expanded="false">
          <h3 class="faq__question"><?php echo esc_html($item['question']); ?></h3>
          <span class="faq__toggle" aria-hidden="true"></span>
        </button>
        <div class="faq__panel" hidden>
          <div class="faq__answer">
            <?php echo apply_filters('acf_the_content', str_replace('&nbsp;', ' ', $item['answer'])); ?>
          </div>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</div>
<?php endif; ?>
