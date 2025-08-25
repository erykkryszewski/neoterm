<?php
$url = 'http://' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
$section_id = get_field('section_id');
$title = get_field('title');
$boxes = get_field('boxes'); // icon, title, text

$slider = get_field('slider');
?>

<div class="services">
  <?php if (!empty($section_id)): ?><div class="section-id" id="<?php echo esc_html(
  $section_id,
); ?>"></div><?php endif; ?>
  <div class="container">
    <div class="services__wrapper">
      <div class="row">
        <?php if (!empty($title)): ?>
        <div class="col-lg-4">
          <div class="services__column services__column--left">
            <h2 class="services__title"><?php echo apply_filters('the_title', $title); ?></h2>
          </div>
        </div>
        <?php endif; ?>
        <?php if (!empty($boxes)): ?>
        <div class="col-lg-8 <?php if (empty($title)) {
          echo 'col-lg-12';
        } ?>">
          <div class="services__column services__column--right">
            <div class="services__boxes">
              <?php foreach ($boxes as $key => $item): ?>
              <div class="services__box">
                <?php if (!empty($item['icon'])): ?>
                <div class="services__box-icon">
                  <?php echo wp_get_attachment_image($item['icon'], 'full', '', ['class' => '']); ?>
                </div>
                <?php endif; ?>
                <?php if (!empty($item['title'])): ?>
                <h3 class="services__box-title"><?php echo apply_filters('the_title', $item['title']); ?></h3>
                <?php endif; ?>
                <?php if (!empty($item['text'])): ?>
                <div class="services__box-text">
                  <?php echo apply_filters('acf_the_content', $item['text']); ?>
                </div>
                <?php endif; ?>
                <?php endforeach; ?>
              </div>
            </div>
          </div>
          <?php endif; ?>
        </div>
        <?php if (!empty($slider)): ?>
        <div class="row">
          <div class="col-12">
            <div class="services__slider">
              <?php foreach ($slider as $key => $item): ?>
              <div class="services__item">
                <?php if (!empty($item['icon'])): ?>
                <div class="services__icon">
                  <?php echo wp_get_attachment_image($item['icon'], 'full', '', ['class' => '']); ?>
                </div>
                <?php endif; ?>
                <?php if (!empty($item['text'])): ?>
                <?php echo apply_filters('acf_the_content', $item['text']); ?>
                <?php endif; ?>
              </div>
              <?php endforeach; ?>
            </div>
          </div>
        </div>
        <?php endif; ?>
      </div>
    </div>
  </div>