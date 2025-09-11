<?php

/**
 * This file contains single post content
 *
 * @package seoleadertheme
 * @license GPL-3.0-or-later
 */

get_header();
global $post;

$post = get_post();
$page_id = $post->ID;

$prev_post = get_previous_post();
$next_post = get_next_post();

// CPT
$different_hero_on_single_view = get_field('different_hero_on_single_view', $page_id);
?>

<main id="main" class="main main--subpage">
  <?php if (have_posts()): ?>
  <?php while (have_posts()):
    the_post(); ?>
  <div class="single-blog-post">
    <div class="post-hero">
      <div class="container">
        <div class="nt-breadcrumbs">
          <div class="container">
            <div class="nt-breadcrumbs__items">
              <?php if (function_exists('rank_math_the_breadcrumbs')) {
                rank_math_the_breadcrumbs();
              } ?>
            </div>
          </div>
        </div>
        <div class="post-hero__wrapper">
          <div>
            <?php if (!empty(get_the_title())): ?>
            <h1><?php the_title(); ?></h1>
            <?php endif; ?>
            <?php if (!empty(get_the_excerpt())): ?>
            <p><?php the_excerpt(); ?></p>
            <?php endif; ?>
          </div>
          <?php if (!empty($different_hero_on_single_view)): ?>
          <div class="single-blog-post__image">
            <?php echo wp_get_attachment_image($different_hero_on_single_view, 'large', '', [
              'class' => '',
            ]); ?>
          </div>
          <?php elseif (!empty(get_post_thumbnail_id($post->ID))): ?>
          <div class="single-blog-post__image">
            <?php echo wp_get_attachment_image(get_post_thumbnail_id($post->ID), 'large', '', [
              'class' => 'object-fit-cover',
            ]); ?>
          </div>
          <?php endif; ?>
        </div>
      </div>
    </div>
    <div class="container">
      <div class="single-blog-post__wrapper">
        <div class="single-blog-post__content">
          <?php the_content(); ?>
          <!-- tags -->
          <?php
          $tags = get_the_tags();
          if ($tags): ?>
          <div class="single-blog-post__tags">
            <p>
              <strong><?php esc_html_e('Tagi Artykułu:', 'seoleadertheme'); ?></strong>
              <?php foreach ($tags as $tag): ?>
              <span class="single-blog-post__tag">
                <a href="<?php echo esc_url(get_tag_link($tag->term_id)); ?>">
                  #<?php echo esc_html($tag->name); ?>
                </a>
              </span>
              <?php endforeach; ?>
            </p>
          </div>
          <?php endif;
          ?>


        </div>
        <?php
        // get as many as you can from the same category, if not fill with any posts, if nothing remove sidebar

        $current_id = get_the_ID();
        $cats = get_the_terms($current_id, 'category');
        $cat_ids = $cats ? wp_list_pluck($cats, 'term_id') : [];

        $collected = [];
        $exclude_ids = [$current_id];

        if (!empty($cat_ids)) {
          $q_same = new WP_Query([
            'post_type' => 'post',
            'posts_per_page' => 3,
            'orderby' => 'rand',
            'post__not_in' => $exclude_ids,
            'ignore_sticky_posts' => true,
            'no_found_rows' => true,
            'tax_query' => [
              [
                'taxonomy' => 'category',
                'field' => 'term_id',
                'terms' => $cat_ids,
                'operator' => 'IN',
              ],
            ],
          ]);
          if ($q_same->have_posts()) {
            foreach ($q_same->posts as $p) {
              $collected[] = $p;
              $exclude_ids[] = $p->ID;
            }
          }
          wp_reset_postdata();
        }

        $need_more = 3 - count($collected);
        if ($need_more > 0) {
          $q_fill = new WP_Query([
            'post_type' => 'post',
            'posts_per_page' => $need_more,
            'orderby' => 'rand',
            'post__not_in' => $exclude_ids,
            'ignore_sticky_posts' => true,
            'no_found_rows' => true,
          ]);
          if ($q_fill->have_posts()) {
            foreach ($q_fill->posts as $p) {
              $collected[] = $p;
            }
          }
          wp_reset_postdata();
        }
        ?>

        <?php if (!empty($collected)): ?>
        <div class="single-blog-post__sidebar">
          <?php
          foreach ($collected as $p):
            setup_postdata($p); ?>
          <div class="single-blog-post__similar-post">
            <h3><?php echo esc_html(get_the_title($p)); ?></h3>
            <?php
            $excerpt_text = '';

            if (has_excerpt($p)) {
              $excerpt_text = get_the_excerpt($p);
            } else {
              $content = wp_strip_all_tags(get_post_field('post_content', $p));
              $sentences = preg_split('/(?<=[\.\?\!])\s+/', trim($content), 3);
              if (!empty($sentences[0])) {
                $excerpt_text .= $sentences[0];
              }
              if (!empty($sentences[1])) {
                $excerpt_text .= ' ' . $sentences[1];
              }
            }

            $excerpt_text = trim($excerpt_text);

            if ($excerpt_text !== '') {
              $excerpt_text = mb_substr($excerpt_text, 0, 227);
              echo '<p>' . esc_html($excerpt_text) . '</p>';
            }
            ?>

            <a class="arrow-link" href="<?php echo esc_url(get_permalink($p)); ?>"><?php echo esc_html_e(
  'Więcej',
  'soleadertheme',
); ?></a>
          </div>
          <?php
          endforeach;
          wp_reset_postdata();
          ?>
        </div>
        <?php endif; ?>

      </div>



      <div class="single-blog-post__slider">
        <h2><?php echo esc_html_e('Baza wiedzy', 'seoleadertheme'); ?></h2>
        <?php
        $recent_posts_slider = new WP_Query([
          'post_type' => 'post',
          'posts_per_page' => 10,
          'post__not_in' => [get_the_ID()],
          'ignore_sticky_posts' => true,
          'no_found_rows' => true,
          'orderby' => 'date',
          'order' => 'DESC',
        ]);

        if ($recent_posts_slider->have_posts()): ?>
        <div class="theme-blog__carousel">
          <?php while ($recent_posts_slider->have_posts()):

            $recent_posts_slider->the_post();
            $permalink = get_permalink();
            $tags = get_the_tags();
            ?>
          <div class="theme-blog__item">
            <?php if (!empty($permalink)): ?>
            <a href="<?php echo esc_url($permalink); ?>" class="cover"></a>
            <?php endif; ?>
            <div>
              <?php if ($tags): ?>
              <div class="theme-blog__tags">
                <?php foreach ($tags as $tag): ?>
                <a href="<?php echo esc_url(get_tag_link($tag->term_id)); ?>">
                  #<?php echo esc_html($tag->name); ?>
                </a>
                <?php endforeach; ?>
              </div>
              <?php endif; ?>

              <?php if (!empty($permalink)): ?>
              <a href="<?php echo esc_url($permalink); ?>" class="theme-blog__title">
                <?php the_title(); ?>
              </a>
              <?php endif; ?>
            </div>

            <div>
              <?php if (has_post_thumbnail()): ?>
              <div class="theme-blog__image">
                <?php if (!empty($permalink)): ?>
                <a href="<?php echo esc_url($permalink); ?>" class="cover"></a>
                <?php endif; ?>
                <?php echo wp_get_attachment_image(get_post_thumbnail_id(), 'large', false, [
                  'class' => 'object-fit-cover',
                ]); ?>
              </div>
              <?php endif; ?>

              <div class="theme-blog__date"><?php echo esc_html(get_the_date()); ?></div>
            </div>
          </div>
          <?php
          endwhile; ?>
        </div>
        <?php endif;
        wp_reset_postdata();
        ?>
      </div>


    </div>
  </div>
  <?php
  endwhile; ?>
  <?php endif; ?>
</main>
<?php get_footer(); ?>