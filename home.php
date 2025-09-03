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
          <?php
          $default_cat = (int) get_option('default_category');
          $terms = get_terms([
            'taxonomy' => 'category',
            'hide_empty' => true,
            'orderby' => 'name',
            'order' => 'ASC',
            'exclude' => [$default_cat],
          ]);

          $total_count = (int) wp_count_posts('post')->publish;
          $search_query = get_search_query();
          $blog_root_id = (int) get_option('page_for_posts');
          $all_url = $blog_root_id ? get_permalink($blog_root_id) : home_url('/');
          $is_all_active = !is_category() && !is_search();
          ?>
          <div class="blog-filter">
            <form class="blog-filter__search" role="search" method="get" action="<?php echo esc_url(home_url('/')); ?>">
              <button type="button" class="blog-filter__search-icon"
                aria-label="<?php esc_attr_e('Szukaj', 'seoleadertheme'); ?>">
                <img src="<?php echo get_template_directory_uri(); ?>/images/search-icon.svg" alt="">
              </button>
              <input class="blog-filter__search-input" type="search" name="s"
                placeholder="<?php esc_attr_e('Wyszukaj', 'seoleadertheme'); ?>"
                value="<?php echo esc_attr($search_query); ?>">
              <input type="hidden" name="post_type" value="post">
              <button class="blog-filter__search-submit" type="submit"
                aria-label="<?php esc_attr_e('Szukaj', 'seoleadertheme'); ?>"></button>
            </form>

            <nav class="blog-filter__nav" aria-label="<?php esc_attr_e('Filtr kategorii', 'seoleadertheme'); ?>">
              <ul class="blog-filter__list">
                <li class="blog-filter__item">
                  <a class="blog-filter__link <?php echo $is_all_active ? 'blog-filter__link--active' : ''; ?>"
                    href="<?php echo esc_url($all_url); ?>">
                    <span class="blog-filter__label"><?php esc_html_e('Wszystko', 'seoleadertheme'); ?></span>
                    <span class="blog-filter__count"><?php echo (int) $total_count; ?></span>
                  </a>
                </li>
                <?php if (!is_wp_error($terms) && !empty($terms)): ?>
                <?php foreach ($terms as $term): ?>
                <?php
                $active = is_category($term->term_id);
                $link = get_term_link($term);
                ?>
                <li class="blog-filter__item">
                  <a class="blog-filter__link <?php echo $active ? 'blog-filter__link--active' : ''; ?>"
                    href="<?php echo esc_url($link); ?>">
                    <span class="blog-filter__label"><?php echo esc_html($term->name); ?></span>
                    <span class="blog-filter__count"><?php echo (int) $term->count; ?></span>
                  </a>
                </li>
                <?php endforeach; ?>
                <?php endif; ?>
              </ul>
            </nav>
          </div>
        </div>



        <div class="theme-blog__wrapper">

          <?php if (!empty($blog_archive_title) && !empty($blog_archive_text)): ?>
          <div class="theme-blog__intro">
            <h1 class="theme-blog__section-title"><?php echo esc_html($blog_archive_title); ?></h1>
            <?php echo apply_filters('acf_the_content', $blog_archive_text); ?>
          </div>
          <?php endif; ?>

          <div class="theme-blog__items">

            <?php while (have_posts()):
              the_post(); ?>

            <?php
            $permalink = get_permalink();
            $tags = get_the_tags();
            $is_first = $wp_query->current_post === 0;
            ?>


            <div class="theme-blog__column <?php echo $is_first && has_post_thumbnail()
              ? 'theme-blog__column--big'
              : ''; ?>">

              <div class="theme-blog__item <?php echo $is_first && has_post_thumbnail()
                ? 'theme-blog__item--big'
                : ''; ?>">
                <div>
                  <?php if ($tags): ?>
                  <div class="theme-blog__tags">
                    <?php foreach ($tags as $tag): ?>
                    <a href="<?php echo esc_url(get_tag_link($tag->term_id)); ?>">#<?php echo esc_html(
  $tag->name,
); ?></a>
                    <?php endforeach; ?>
                  </div>
                  <?php endif; ?>
                  <?php if (!empty($permalink)): ?>
                  <a href="<?php echo esc_url($permalink); ?>" class="theme-blog__title <?php echo $is_first &&
has_post_thumbnail()
  ? 'theme-blog__title--big'
  : ''; ?>"><?php the_title(); ?></a>
                  <?php endif; ?>
                </div>
                <div>
                  <?php if (!empty(get_post_thumbnail_id())): ?>
                  <div class="theme-blog__image <?php echo $is_first && has_post_thumbnail()
                    ? 'theme-blog__image--big'
                    : ''; ?>">
                    <?php if (!empty($permalink)): ?>
                    <a href="<?php echo esc_url($permalink); ?>" class="cover"></a>
                    <?php endif; ?>
                    <?php echo wp_get_attachment_image(get_post_thumbnail_id(), 'full', false, [
                      'class' => 'object-fit-cover',
                    ]); ?>
                  </div>
                  <?php endif; ?>
                  <div class="theme-blog__date"><?php echo esc_html(get_the_date()); ?></div>
                </div>
              </div>

            </div>


            <?php
            endwhile; ?>

          </div>

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
