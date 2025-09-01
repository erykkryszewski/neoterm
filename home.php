<?php

get_header();
global $post;

$post = get_post();
$page_id = $post->ID;

$blog_page = filter_input(INPUT_GET, 'blog-page', FILTER_SANITIZE_NUMBER_INT);
$current_blog_page = $blog_page ? $blog_page : 1;

$blog_posts_number = get_field('blog_posts_number', 'options');
$blog_archive_title = get_field('blog_archive_title', 'options');
$blog_archive_text = get_field('blog_archive_text', 'options');

$args = [
  'post_status' => 'publish',
  'posts_per_page' => $blog_posts_number,
  'orderby' => 'title',
  'paged' => $current_blog_page,
];

$global_logo = get_field('global_logo', 'options');
?>

<main id="main" class="main <?php if (!is_front_page()) {
  echo 'main--subpage';
} ?>">

  <!-- max 12 items -->
  <?php if (have_posts()): ?>
  <div class="theme-blog theme-blog--subpage">
    <div class="container-fluid container-fluid--padding">
      <div class="theme-blog__container">
        <div class="theme-blog__sidebar">
          <h4>Tu filtracja</h4>
        </div>
        <div class="theme-blog__wrapper">

          <?php if (!empty($blog_archive_title) && !empty($blog_archive_text)): ?>
          <div class="theme-blog__intro">
            <h1 class="theme-blog__section-title"><?php echo esc_html($blog_archive_title); ?></h1>
            <?php echo apply_filters('acf_the_content', $blog_archive_text); ?>
          </div>
          <?php endif; ?>

          <?php while (have_posts()): ?>
          <?php the_post(); ?>
          <div class="theme-blog__column">
            <div class="theme-blog__item">
              <div class="theme-blog__image">
                <a href="<?php the_permalink(); ?>" class="cover"></a>
                <?php echo wp_get_attachment_image(get_post_thumbnail_id(), 'full', '', [
                  'class' => 'object-fit-cover',
                ]); ?>
              </div>
              <div class="theme-blog__content">
                <div>
                  <a href="<?php the_permalink(); ?>" class="theme-blog__title"><?php the_title(); ?></a>
                  <p>
                    <?php
                    $excerpt = get_the_excerpt();
                    if (empty($excerpt)) {
                      echo substr(get_content_excerpt(), 0, 150) . '...';
                    } else {
                      echo substr($excerpt, 0, 150) . '...';
                    }
                    ?>
                  </p>
                </div>
                <a href="<?php the_permalink(); ?>" class="theme-blog__button button"><?php _e(
  'Czytaj więcej',
  'seoleadertheme',
); ?></a>
              </div>
            </div>
          </div>
          <?php endwhile; ?>
        </div>
      </div>
      <div class="pagination mt-5">
        <?php echo paginate_links([
          'base' => str_replace(999999999, '%#%', esc_url(get_pagenum_link(999999999))),
          'current' => max(1, get_query_var('paged')),
          'format' => '?paged=%#%',
          'show_all' => false,
          'type' => 'list',
          'end_size' => 2,
          'mid_size' => 1,
          'prev_next' => true,
          'prev_text' => '',
          'next_text' => '',
          'add_args' => false,
          'add_fragment' => '',
        ]); ?>
      </div>
      <?php wp_reset_postdata(); ?>
      <?php wp_reset_query(); ?>
    </div>
  </div>
  <?php endif; ?>
</main>
<?php get_footer(); ?>
