<?php
$url = 'http://' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
$background = get_field('background');
$section_id = get_field('section_id');
$faq = get_field('faq');
$title_inside = get_field('title_inside');
?>

<?php if (!empty($faq)): ?>
<div class="faq <?php if (!empty($title_inside)) {
  echo 'faq--contact';
} ?>">
  <?php if (!empty($section_id)): ?>
  <div class="section-id" id="<?php echo esc_html($section_id); ?>"></div>
  <?php endif; ?>
  <div class="container">
    <div class="faq__container <?php if (!empty($title_inside)) {
      echo 'faq__container--contact';
    } ?>">
      <?php if (!empty($title_inside)): ?>
      <div class="section-title faq__section-title">
        <div class="section-title__wrapper">
          <span class="section-title__decoration-text">FAQ</span>
          <h3 class="section-title__title"><?php echo apply_filters('the_title', $title_inside); ?>
          </h3>
        </div>
      </div>
      <?php endif; ?>
      <div class="faq__wrapper <?php if (!empty($title_inside)) {
        echo 'faq__wrapper--contact';
      } ?>">
        <div class="faq__list <?php if (!empty($title_inside)) {
          echo 'faq__list--contact';
        } ?>">
          <?php foreach ($faq as $index => $item): ?>
          <div class="faq__item <?php if (!empty($title_inside)) {
            echo 'faq__item--contact';
          } ?>">
            <button class="faq__header <?php if (!empty($title_inside)) {
              echo 'faq__header--contact';
            } ?>" type="button" aria-expanded="false">
              <h3 class="faq__question <?php if (!empty($title_inside)) {
                echo 'faq__question--contact';
              } ?>"><?php echo esc_html($item['question']); ?></h3>
              <span class="faq__toggle" aria-hidden="true"></span>
            </button>
            <div class="faq__panel <?php if (!empty($title_inside)) {
              echo 'faq__panel--contact';
            } ?>" hidden>
              <div class="faq__answer <?php if (!empty($title_inside)) {
                echo 'faq__answer--contact';
              } ?>">
                <?php echo apply_filters('acf_the_content', str_replace('&nbsp;', ' ', $item['answer'])); ?>
              </div>
            </div>
          </div>
          <?php endforeach; ?>
        </div>
      </div>
    </div>
  </div>
</div>
<?php endif; ?>
