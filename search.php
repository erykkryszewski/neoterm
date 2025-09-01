<?php
get_header();
$search_query = get_search_query();
$blog_root_id = (int) get_option('page_for_posts');
$all_url = $blog_root_id ? get_permalink($blog_root_id) : home_url('/');
$total_count = (int) wp_count_posts('post')->publish;
$default_cat = (int) get_option('default_category');
$terms = get_terms([
  'taxonomy' => 'category',
  'hide_empty' => true,
  'orderby' => 'name',
  'order' => 'ASC',
  'exclude' => [$default_cat],
]);
?>
<main id="main" class="main <?php if (!is_front_page()) {
  echo 'main--subpage';
} ?>">
  <div class="theme-blog theme-blog--subpage">
    <div class="container-fluid container-fluid--padding">
      <div class="theme-blog__container">
        <div class="theme-blog__sidebar">
          <div class="blog-filter">
            <form class="blog-filter__search" role="search" method="get" action="<?php echo esc_url(home_url('/')); ?>">
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
                  <a class="blog-filter__link" href="<?php echo esc_url($all_url); ?>">
                    <span class="blog-filter__label"><?php esc_html_e('Wszystko', 'seoleadertheme'); ?></span>
                    <span class="blog-filter__count"><?php echo (int) $total_count; ?></span>
                  </a>
                </li>
                <?php if (!is_wp_error($terms) && !empty($terms)): ?>
                <?php foreach ($terms as $term): ?>
                <?php $link = get_term_link($term); ?>
                <li class="blog-filter__item">
                  <a class="blog-filter__link" href="<?php echo esc_url($link); ?>">
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
          <div class="theme-blog__intro">
            <h1 class="theme-blog__section-title"><?php esc_html_e('Wyniki wyszukiwania', 'seoleadertheme'); ?>:
              <?php echo esc_html($search_query); ?></h1>
          </div>
          <?php if (have_posts()): ?>
          <?php while (have_posts()):
            the_post(); ?>
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
                    $text = empty($excerpt) ? wp_strip_all_tags(get_the_content()) : $excerpt;
                    echo esc_html(mb_substr($text, 0, 150)) . '...';
                    ?>
                  </p>
                </div>
                <a href="<?php the_permalink(); ?>"
                  class="theme-blog__button button"><?php _e('Czytaj więcej', 'seoleadertheme'); ?></a>
              </div>
            </div>
          </div>
          <?php
          endwhile; ?>
          <?php else: ?>
          <p><?php esc_html_e('Brak wyników.', 'seoleadertheme'); ?></p>
          <?php endif; ?>
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
</main>
<?php get_footer(); ?>
