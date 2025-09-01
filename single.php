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
    <div class="container">
      <div class="single-blog-post__wrapper">
        <div class="single-blog-post__content">
          <div class="single-blog-post__hero">
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
          <p><?php the_content(); ?></p>
        </div>
        <div class="single-blog-post__sidebar">
          <h3>3 losowe posty z tej kategorii lub jeśli nie ma z tej to jakiekolwiek</h3>
        </div>
      </div>
    </div>
  </div>
  <?php
  endwhile; ?>
  <?php endif; ?>
</main>
<?php get_footer(); ?>
