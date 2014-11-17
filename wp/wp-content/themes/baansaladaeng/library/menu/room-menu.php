<?php
/**
 * Created by PhpStorm.
 * User: Rux
 * Date: 16/10/2557
 * Time: 14:37 น.
 */


//-----------------------Room Type Post----------------------------------------//

function room_register()
{
    $labels = array(
        'name' => _x('Rooms', 'post type general name'),
        'singular_name' => _x('Room', 'post type singular name'),
        'add_new' => _x('Add New', 'book'),
        'add_new_item' => __('Add New Room'),
        'edit_item' => __('Edit Room'),
        'new_item' => __('New Room'),
        //'all_items'          => __( 'All Rooms' ),
        'view_item' => __('View Room'),
        'search_items' => __('Search Rooms'),
        'not_found' => __('No products found'),
        'not_found_in_trash' => __('No products found in the Trash'),
        'parent_item_colon' => '',
        'menu_name' => 'Rooms'
    );

    $args = array(
        'labels' => $labels,
        'public' => true,
        'publicly_queryable' => true,
        'show_ui' => true,
        'query_var' => true,
        'menu_icon' => get_stylesheet_directory_uri() . '/library/images/icon_room.png',
        'rewrite' => true,
        'capability_type' => 'post',
        'hierarchical' => false,
        'menu_position' => 5,
        'supports' => array('title', 'editor', 'thumbnail'),
//        'show_in_menu' => 'ics_theme_settings',
//        "show_in_nav_menus" => true,
//        "show_in_admin_bar" => true,

        'taxonomy' => array('category', /*'post_tag'*/),
    );

    register_post_type('room', $args);
//    add_submenu_page('edit.php?post_type=room', 'WP Backgrounds Pro', "", "");
    register_taxonomy('room-category',
        'Rooms',
        array(
            'hierarchical' => true,
            'label' => __('Rooms Categories'
            ))); // portfolio categories
}

function admin_init()
{
//    add_meta_box("price-meta", "Price", "price", "room", "side", "low");
    add_meta_box("credits_meta", "Room Options", "credits_meta", "room", "normal", "low");
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

function credits_meta()
{
    global $post;
    $custom = get_post_custom($post->ID);
    $type = $custom["type"][0];
    $size = $custom["size"][0];
    $designer = $custom["designer"][0];
    $price = $custom["price"][0];
    $recommend = $custom["recommend"][0];
    $facilities = $custom["facilities"][0];
//    $price = $custom["price"][0];
//    $designers = $custom["designers"][0];
//    $developers = $custom["developers"][0];
//    $producers = $custom["producers"][0];
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
    </div><?php $meta_values = get_post_meta($post->ID, 'room_image_gallery', true); ?>
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
                    <?php
                    }
                }
            } ?>
        </ul>
        <div class="clear"></div>
        <table>
            <tr>
                <td>
                    <label for="type">Type:</label></td>
                <td>
                    <input name="type" value="<?php echo $type; ?>"/></td>
            </tr>
            <tr>
                <td><label for="size">Size:</label></td>
                <td><input name="size" value="<?php echo $size; ?>"/> sq.mtrs</td>
            </tr>
            <tr>
                <td><label for="designer">Designer:</label></td>
                <td><input name="designer" value="<?php echo $designer; ?>"/></td>
            </tr>
            <tr>
                <td><label for="price">Price:</label></td>
                <td><input name="price" value="<?php echo $price; ?>"/> THB/night (Incl Breakfast)</td>
            </tr>
            <tr>
                <td><label for="recommend">Recommend:</label></td>
                <td><input name="recommend" value="1" type="checkbox"
                        <?php echo $recommend == 1 ? "checked" : "" ?>/></td>
            </tr>
            <tr><td colspan="2"></td> </tr>
            <tr>
                <?php
                if (empty($facilities)) {
                    $arrayFacilities = array(0, 0, 0, 0, 0, 0, 0, 0, 0, 0);
                } else {
                    $arrayFacilities = explode(',', $facilities);
                }
                ?>
                <td valign="top"><label for="">Facilities :</label></td>
                <td><input type="hidden" id="facilities" name="facilities" value="<?php echo $facilities; ?>">
                    <input class="facilities"
                           type="checkbox" <?php echo @$arrayFacilities[0] ? 'checked' : ""; ?> /> BREAKFAST</br>
                    <input class="facilities"
                           type="checkbox" <?php echo @$arrayFacilities[1] ? 'checked' : ""; ?> /> BREAKFAST</br>
                    <input class="facilities"
                           type="checkbox" <?php echo @$arrayFacilities[2] ? 'checked' : ""; ?> /> EN-SUITE
                    BATHROOM</br>
                    <input class="facilities"
                           type="checkbox" <?php echo @$arrayFacilities[3] ? 'checked' : ""; ?> /> FLAT SCREEN TV</br>
                    <input class="facilities"
                           type="checkbox" <?php echo @$arrayFacilities[4] ? 'checked' : ""; ?> /> MINI BAR</br>
                    <input class="facilities"
                           type="checkbox" <?php echo @$arrayFacilities[5] ? 'checked' : ""; ?> />SAFETY DEPOSIT
                    BOX</br>
                    <input class="facilities"
                           type="checkbox" <?php echo @$arrayFacilities[6] ? 'checked' : ""; ?> /> KING SIZE BED</br>
                    <input class="facilities"
                           type="checkbox" <?php echo @$arrayFacilities[7] ? 'checked' : ""; ?> /> QUEEN SIZE BED</br>
                    <input class="facilities"
                           type="checkbox" <?php echo @$arrayFacilities[8] ? 'checked' : ""; ?> /> TWIN BED</br>
                    <input class="facilities"
                           type="checkbox" <?php echo @$arrayFacilities[9] ? 'checked' : ""; ?> /> PRIVATE BALCONY</br>

                    <script>
                        $(".facilities").click(function () {
                            var arrFacilities = [];
                            $(".facilities").each(function () {
                                if ($(this).prop('checked')) {
                                    arrFacilities.push(1);
                                } else {
                                    arrFacilities.push(0);
                                }
                            });
                            $("#facilities").val(arrFacilities);
                        });
                    </script>
                </td>
            </tr>
        </table>
    </div>
    </p>
<?
}

//add_meta_box( $id, $title, $callback, $page, $context, $priority );
function save_details()
{
    global $post;

    update_post_meta($post->ID, "type", trim($_POST["type"]));
    update_post_meta($post->ID, "size", trim($_POST["size"]));
    update_post_meta($post->ID, "designer", trim($_POST["designer"]));
    update_post_meta($post->ID, "price", trim($_POST["price"]));
    update_post_meta($post->ID, "recommend", trim($_POST["recommend"]));
    update_post_meta($post->ID, "facilities", $_POST['facilities']);
//    update_post_meta($post->ID, "designers", $_POST["designers"]);
//    update_post_meta($post->ID, "developers", $_POST["developers"]);
//    update_post_meta($post->ID, "producers", $_POST["producers"]);

    $imageUrlName = "image_url";
    $post_type = get_post_type_object($post->post_type);
    $new_meta_value = (isset($_POST[$imageUrlName]) ? $_POST[$imageUrlName] : FALSE);
    if (!current_user_can($post_type->cap->edit_post, $post->ID))
        return $post->ID;
    $meta_key = 'room_image_gallery';
    $meta_value = get_post_meta($post->ID, $meta_key, true);
    if ($new_meta_value && '' == $meta_value)
        add_post_meta($post->ID, $meta_key, $new_meta_value, true);
    elseif ($new_meta_value && $new_meta_value != $meta_value)
        update_post_meta($post->ID, $meta_key, $new_meta_value);
    elseif ('' == $new_meta_value && $meta_value)
        delete_post_meta($post->ID, $meta_key, $meta_value);
    return true;
}

function room_edit_columns($columns)
{
    $columns = array(
        "cb" => '<input type="checkbox" />',
        "title" => "Room Title",
//        "description" => "Description",
        "type" => "Type",
        "size" => "Size",
        "designer" => "Designer",
        "price" => "Price",
        "recommend" => "Recommend",
        "category" => "Categorys",
        "date" => "Date",
    );

    return $columns;
}

function room_custom_columns($column)
{
    global $post;

    $custom = get_post_custom();
    switch ($column) {
        case "description":
            the_excerpt();
            break;
        case "type":
            echo $custom["type"][0];
            break;
        case "size":
            echo $custom["size"][0];
            break;
        case "designer":
            echo $custom["designer"][0];
            break;
        case "price":
            echo $custom["price"][0];
            break;
        case "recommend":
            echo $custom["recommend"][0];
            break;
        case "category":
            echo get_the_term_list($post->ID, 'Category', '', ', ', '');
            break;
    }
}

add_action('init', 'room_register');

register_taxonomy("Category", array("room"), array(
    "hierarchical" => true,
    "label" => "Category",
    "singular_label" => "Category",
    "rewrite" => true
));

add_action("admin_init", "admin_init");

global $post;
$custom = get_post_custom($post->ID);
add_action('save_post', 'save_details');
add_action("manage_posts_custom_column", "room_custom_columns");
add_filter("manage_edit-room_columns", "room_edit_columns");

add_theme_support('post-thumbnails');
register_post_type('room', $argc);

//------------------------------- END Room Type Post--------------------------------//

// CALLBACK
function show_people_box($post)
{
    $metas = json_decode(get_post_meta($post->ID, 'people', true));
    ?>
    <?php
    $hiterms = get_terms('people', array('orderby' => 'slug', 'parent' => 0, 'hide_empty' => false));

    ?>
    <?php foreach ($hiterms as $key => $hiterm) { ?>
    <h2 style="text-align:center;"><?php echo $hiterm->name; ?></h2>
    <table width="100%">
        <?php
        $args = array(
            'post_type' => 'people',
            'orderby' => 'menu_order',
            'post_parent' => 0,
            'tax_query' => array(array(
                'taxonomy' => 'people',
                'field' => 'id',
                'terms' => $hiterm->term_id
            )));
        ?>
        <?php
        $query = new WP_Query($args);
        while ($query->have_posts()) {
            $query->the_post();
            ?>
            <?php
            $children = get_children(array('post_type' => 'people', 'post_parent' => get_the_ID()));
            if ($children) {
                ?>
                <tr>
                    <td><input name="people[name]" type="text"/></td>
                    <td><input name="people[lastname]" type="text"/></td>
                    <td><input name="people[email]" type="text"/></td>
                </tr>
                <?php

                $args_2 = array('post_type' => 'people', 'post_parent' => get_the_ID());
                $query_2 = new WP_Query($args_2);
                while ($query_2->have_posts()) {
                    $query_2->the_post();
                    ?>
                    <tr>
                        <td><input name="people[name]" type="text"/></td>
                        <td><input name="people[lastname]" type="text"/></td>
                        <td><input name="people[email]" type="text"/></td>
                    </tr>
                <?php
                }
            } else {

                ?>
                <tr>
                    <td><input name="people[name]" type="text"/></td>
                    <td><input name="people[lastname]" type="text"/></td>
                    <td><input name="people[email]" type="text"/></td>
                </tr>
            <?php
            }
            ?>
        <?php
        }
        wp_reset_postdata();
        ?>
    </table>
<?php } ?>
<?php
}

// SAVE
add_action('save_post', 'save_people_box');
function save_people_box()
{

    foreach ($_POST['people'] as $key => $value) {
        $peoples[$key] = $value;
    }

    global $post;
    update_post_meta($post->ID, 'people', json_encode($peoples));

}