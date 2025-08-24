<?php
add_action(
  'wp_nav_menu_item_custom_fields',
  function ($item_id, $item, $depth, $args) {
    $icon_id = (int) get_post_meta($item_id, '_menu_item_icon', true);
    $image = $icon_id ? wp_get_attachment_image($icon_id, 'thumbnail') : '';
    ?>
<p class="description description-wide">
  <label for="edit-menu-item-icon-<?php echo esc_attr($item_id); ?>">Ikona</label><br>
  <input type="hidden" class="widefat menu-item-icon" name="menu-item-icon[<?php echo esc_attr($item_id); ?>]"
    id="edit-menu-item-icon-<?php echo esc_attr($item_id); ?>" value="<?php echo esc_attr($icon_id); ?>">
  <span class="menu-item-icon-preview"><?php echo $image; ?></span><br>
  <button type="button" class="button upload-menu-item-icon">Wybierz ikonę</button>
  <button type="button" class="button remove-menu-item-icon">Usuń</button>
</p>
<?php
  },
  10,
  4,
);

add_action(
  'wp_update_nav_menu_item',
  function ($menu_id, $menu_item_db_id) {
    if (isset($_POST['menu-item-icon'][$menu_item_db_id])) {
      update_post_meta($menu_item_db_id, '_menu_item_icon', (int) $_POST['menu-item-icon'][$menu_item_db_id]);
    } else {
      delete_post_meta($menu_item_db_id, '_menu_item_icon');
    }
  },
  10,
  2,
);

add_action('admin_enqueue_scripts', function ($hook) {
  if ($hook !== 'nav-menus.php') {
    return;
  }
  wp_enqueue_media();
  wp_register_script('menu-item-icons-admin', false, ['jquery'], null, true);
  wp_enqueue_script('menu-item-icons-admin');
  wp_add_inline_script(
    'menu-item-icons-admin',
    "
        jQuery(function($){
            $(document).on('click', '.upload-menu-item-icon', function(e){
                e.preventDefault();
                var wrap    = $(this).closest('p.description-wide');
                var input   = wrap.find('input.menu-item-icon');
                var preview = wrap.find('.menu-item-icon-preview');
                var frame   = wp.media({
                    title: 'Wybierz ikonę',
                    library: { type: ['image'] },
                    button: { text: 'Użyj tej ikony' },
                    multiple: false
                });
                frame.on('select', function(){
                    var att   = frame.state().get('selection').first().toJSON();
                    var url   = att.sizes && att.sizes.thumbnail ? att.sizes.thumbnail.url : att.url;
                    input.val(att.id).trigger('change');
                    preview.html('<img src=\"'+url+'\" style=\"max-width:40px;height:auto;\"/>');
                });
                frame.open();
            });
            $(document).on('click', '.remove-menu-item-icon', function(e){
                e.preventDefault();
                var wrap = $(this).closest('p.description-wide');
                wrap.find('input.menu-item-icon').val('').trigger('change');
                wrap.find('.menu-item-icon-preview').empty();
            });
        });
    ",
  );
});

add_filter(
  'nav_menu_item_title',
  function ($title, $item, $args, $depth) {
    $icon_id = (int) get_post_meta($item->ID, '_menu_item_icon', true);
    if ($icon_id) {
      $icon = wp_get_attachment_image($icon_id, 'thumbnail', false, ['class' => 'menu-icon']);
      $title = $icon . ' ' . $title;
    }
    return $title;
  },
  10,
  4,
);
