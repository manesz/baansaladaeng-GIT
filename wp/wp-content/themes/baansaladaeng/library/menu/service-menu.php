<?php
/**
 * Created by PhpStorm.
 * User: Rux
 * Date: 16/10/2557
 * Time: 14:37 น.
 */


//-----------------------Service Type Post----------------------------------------//

function service_register()
{
    $labels = array(
        'name'               => _x( 'Services', 'post type general name' ),
        'singular_name'      => _x( 'Services', 'post type singular name' ),
        'add_new'            => _x( 'Add New', 'book' ),
        'add_new_item'       => __( 'Add New Service' ),
        'edit_item'          => __( 'Edit Service' ),
        'new_item'           => __( 'New Service' ),
        //'all_items'          => __( 'All Service' ),
        'view_item'          => __( 'View Service' ),
        'search_items'       => __( 'Search Service' ),
        'not_found'          => __( 'No products found' ),
        'not_found_in_trash' => __( 'No products found in the Trash' ),
        'parent_item_colon'  => '',
        'menu_name'          => 'Services'
    );

    $args = array(
        'labels' => $labels,
        'public' => true,
        'publicly_queryable' => true,
        'show_ui' => true,
        'query_var' => true,
        'menu_icon' => get_stylesheet_directory_uri() . '/library/images/icon_room_service.png',
        'rewrite' => true,
        'capability_type' => 'post',
        'hierarchical' => false,
        'menu_position' => 6,
        'supports' => array('title', 'editor', 'thumbnail'),
//        'show_in_menu' => 'ics_theme_settings',
//        "show_in_nav_menus" => true,
//        "show_in_admin_bar" => true,
    );

    register_post_type('service', $args);
//    add_submenu_page('edit.php?post_type=service', 'WP Backgrounds Pro', "", "");

}

function service_admin_init()
{
//    add_meta_box("price-meta", "Price", "price", "service", "side", "low");
    add_meta_box("credits_meta", "Service Options", "service_credits_meta", "service", "normal", "low");
}
/*
function price()
{
    global $post;
    $custom = get_post_custom($post->ID);
    $price = $custom["price"][0];
    ?>
    <label for="price">Price:</label>
    <input name="price" value="<?php echo $price; ?>"/>
<?php
}*/

function service_credits_meta()
{
    global $post;
    $custom = get_post_custom($post->ID);
//    $type = $custom["type"][0];
//    $size = $custom["size"][0];
//    $designer = $custom["designer"][0];
    $price = $custom["price"][0];
    ?>
    <!--    <p><label for="price">Price:</label><br/>-->
    <!--        <input type="text" id="price" name="price" value="--><?php //echo $price; ?><!--"/> ฿</p>-->

    <p><label for="uploadImageButton">Image Gallery:</label><br/>
        <script type="text/javascript"
                src="<?php bloginfo('template_directory'); ?>/library/js/image-post-metabox.js"></script>
        <link rel="stylesheet" type="text/css"
              href="<?php bloginfo('template_directory'); ?>/library/css/icon.css"/>
        <link rel="stylesheet" type="text/css"
              href="<?php bloginfo('template_directory'); ?>/library/css/imgslidlist.css"/>
    <div class="misc-pub-section">
        <input type="text" title="Path Image" placeholder="Path Image" size="40" name="pathImg" id="pathImg"><input
            type="button" value="Upload Image" class="button" id="uploadImageButton">
        <button id="imgaddlist" class="button-primary"><i class="icon-plus-2"></i> เพิ่มรูป</button>
    </div><?php $meta_values = get_post_meta($post->ID, 'imgslide', true); ?>
    <div class="tabs-panel" id="imglist-stage" <?php if (!count($meta_values)){ ?>style="display:none"<?php } ?>>
        <ul id="sortable">
            <?php
            if (count($meta_values)) {
                for ($i = 0; $i < count($meta_values); $i++) {
                    if ($meta_values[$i] != '') {
                        ?>
                        <li>
                            <input type="hidden" value="<?php echo $meta_values[$i] ?>" name="image_url[]"/>
                            <a href="#TB_inline?height=400&amp;width=700&amp;inlineId=image_view<?php echo $i; ?>"
                               class="imagebig thickbox" title="ลากเพื่อเรียงใหม่">
                                <img src="<?php echo $meta_values[$i] ?>" width="200" alt="image"/></a>
                            <a href="#" class="delimgsrc" title="ลบรูปนี้"><i class="icon-cancel-2"></i></a>
                            <div id="image_view<?php echo $i; ?>" style="display:none">
                                <h2>Image View</h2>
                                <div style="">
                                    <img src="<?php echo $meta_values[$i] ?>" style="width: 100%;"/>
                                </div>
                            </div>
                        </li>
                    <?php }
                }
            } ?>
        </ul>
        <div class="clear"></div>
        <label for="price">Price:</label>
        <input name="price" value="<?php echo $price; ?>"/> THB/night (Incl Breakfast)
    </div>
    </p>
<?
}

//add_meta_box( $id, $title, $callback, $page, $context, $priority );
function service_save_details()
{
    global $post;

    update_post_meta($post->ID, "price", $_POST["price"]);


    $imageUrlName = "image_url";
    $post_type = get_post_type_object($post->post_type);
    $new_meta_value = (isset($_POST[$imageUrlName]) ? $_POST[$imageUrlName] : FALSE);
    if (!current_user_can($post_type->cap->edit_post, $post->ID))
        return $post->ID;
    $meta_key = 'service_image_gallery';
    $meta_value = get_post_meta($post->ID, $meta_key, true);
    if ($new_meta_value && '' == $meta_value)
        add_post_meta($post->ID, $meta_key, $new_meta_value, true);
    elseif ($new_meta_value && $new_meta_value != $meta_value)
        update_post_meta($post->ID, $meta_key, $new_meta_value);
    elseif ('' == $new_meta_value && $meta_value)
        delete_post_meta($post->ID, $meta_key, $meta_value);
    return true;
}

function service_edit_columns($columns)
{
    $columns = array(
        "cb" => '<input type="checkbox" />',
        "title" => "Service Title",
        "price" => "Price",
        "date" => "Date",
    );

    return $columns;
}

function service_custom_columns($column)
{
    global $post;

    $custom = get_post_custom();
    switch ($column) {
        case "description":
            the_excerpt();
            break;
        case "price":
            echo $custom["price"][0];
            break;
        case "category":
            echo get_the_term_list($post->ID, 'Category', '', ', ', '');
            break;
    }
}

add_action('init', 'service_register');

register_taxonomy("Category", array("service"), array(
    "hierarchical" => true,
    "label" => "Category",
    "singular_label" => "Category",
    "rewrite" => true
));

add_action("admin_init", "service_admin_init");

global $post;
$custom = get_post_custom($post->ID);
add_action('save_post', 'service_save_details');
add_action("manage_posts_custom_column", "service_custom_columns");
add_filter("manage_edit-service_columns", "service_edit_columns");

add_theme_support('post-thumbnails');
register_post_type('service', $argc);

//------------------------------- END Service Type Post--------------------------------//