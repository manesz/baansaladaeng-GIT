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

function admin_init_room()
{
//    add_meta_box("price-meta", "Price", "price", "room", "side", "low");
    add_meta_box("room_option_meta", "Room Options", "meta_room_option", "room", "normal", "low");
    add_meta_box("room_gallery_meta", "Room Gallery", "meta_room_gallery", "room", "normal", "low");
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

function meta_room_gallery()
{
    global $post;
    $custom = get_post_custom($post->ID);
//    $room_plan = $custom["room_plan"][0];
//    $type = $custom["type"][0];
//    $size = $custom["size"][0];
//    $designer = $custom["designer"][0];
//    $price = $custom["price"][0];
//    $recommend_price = $custom["recommend_price"][0];
//    $recommend = $custom[""][0];
//    $facilities = $custom["room_image_gallery"][0];
//    var_dump($facilities);
    ?>
    <label for="btn_upload_image">Image Gallery:</label><br/>
    <script type="text/javascript"
            src="<?php bloginfo('template_directory'); ?>/library/js/image-post-metabox.js"></script>
    <link rel="stylesheet" type="text/css"
          href="<?php bloginfo('template_directory'); ?>/library/css/icon.css"/>
    <link rel="stylesheet" type="text/css"
          href="<?php bloginfo('template_directory'); ?>/library/css/imgslidlist.css"/>
    <div class="misc-pub-section">
        <input type="text" title="Path Image" placeholder="Path Image" size="40" name="pathImg" id="pathImg"><input
            type="button" value="Upload Image" class="button btn_upload_image" id="btn_upload_image"
            data-tbx-id="pathImg">
        <button id="imgaddlist" class="button-primary"><i class="icon-plus-2"></i> Add Image</button>
    </div><?php $meta_values = get_post_meta($post->ID, 'room_image_gallery', true); // var_dump($meta_values); ?>
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

    </div>
<?php
}

function meta_room_option()
{
    global $post;
    $custom = get_post_custom($post->ID);
    $room_plan = $custom["room_plan"][0];
    $type = $custom["type"][0];
    $size = $custom["size"][0];
    $designer = $custom["designer"][0];
    $price = $custom["price"][0];
    $recommend_price = get_post_meta($post->ID, 'recommend_price', true);
    $recommend = $custom["recommend"][0];
    $facilities = $custom["facilities"][0];
    ?>
    <!--    <p><label for="price">Price:</label><br/>-->
    <!--        <input type="text" id="price" name="price" value="--><?php //echo $price; ?><!--"/> ฿</p>-->

    <p>
    <table>
        <tr>
            <td>
                <label for="type">Type:</label></td>
            <td>
                <select id="type" name="type">
                    <option value="">-- Select --</option>
                    <option
                        value="Double king size bed" <?php echo $type == "Double king size bed" ? "selected" : ""; ?>>
                        Double
                        king size bed
                    </option>
                    <option
                        value="Double queen size bed" <?php echo $type == "Double queen size bed" ? "selected" : ""; ?>>
                        Double
                        queen size bed
                    </option>
                    <option
                        value="Twin / Super king size bed" <?php echo $type == "Twin / Super king size bed" ? "selected" : ""; ?>>
                        Twin /
                        Super king size bed
                    </option>
                </select>
            </td>
        </tr>
        <tr>
            <td><label for="size">Size:</label></td>
            <td><input id="size" name="size" value="<?php echo $size; ?>"/> sq.mtrs</td>
        </tr>
        <tr>
            <td><label for="designer">Designer:</label></td>
            <td><input id="designer" name="designer" value="<?php echo $designer; ?>"/></td>
        </tr>
        <tr>
            <td><label for="price">Price:</label></td>
            <td><input id="price" name="price" value="<?php echo $price; ?>"
                       maxlength="15"/> THB/night (Incl Breakfast)
            </td>
        </tr>
        <tr>
            <td valign="top"><label for="recommend_price">Recommended Price:</label></td>
            <td>

                <?php if (empty($recommend_price)) {
                    for ($i = 0; $i < 12; $i++) {
                        $recommend_price[] = '';
                    }
                }
                ?>
                <?php ?>
                <table>
                        <tr>
                            <td>January</td>
                            <td><input id="price" name="recommend_price[]" maxlength="15"
                                       value="<?php echo $recommend_price[0]; ?>"/></td>
                            <td>February</td>
                            <td><input id="price" name="recommend_price[]" maxlength="15"
                                       value="<?php echo $recommend_price[1]; ?>"/></td>
                        </tr>
                        <tr>
                            <td>March</td>
                            <td><input id="price" name="recommend_price[]" maxlength="15"
                                       value="<?php echo $recommend_price[2]; ?>"/></td>
                            <td>April</td>
                            <td><input id="price" name="recommend_price[]" maxlength="15"
                                       value="<?php echo $recommend_price[3]; ?>"/></td>
                        </tr>
                        <tr>
                            <td>May</td>
                            <td><input id="price" name="recommend_price[]" maxlength="15"
                                       value="<?php echo $recommend_price[4]; ?>"/></td>
                            <td>June</td>
                            <td><input id="price" name="recommend_price[]" maxlength="15"
                                       value="<?php echo $recommend_price[5]; ?>"/></td>
                        </tr>
                        <tr>
                            <td>July</td>
                            <td><input id="price" name="recommend_price[]" maxlength="15"
                                       value="<?php echo $recommend_price[6]; ?>"/></td>
                            <td>August</td>
                            <td><input id="price" name="recommend_price[]" maxlength="15"
                                       value="<?php echo $recommend_price[7]; ?>"/></td>
                        </tr>
                        <tr>
                            <td>September</td>
                            <td><input id="price" name="recommend_price[]" maxlength="15"
                                       value="<?php echo $recommend_price[8]; ?>"/></td>
                            <td>October</td>
                            <td><input id="price" name="recommend_price[]" maxlength="15"
                                       value="<?php echo $recommend_price[9]; ?>"/></td>
                        </tr>
                        <tr>
                            <td>November</td>
                            <td><input id="price" name="recommend_price[]" maxlength="15"
                                       value="<?php echo $recommend_price[10]; ?>"/></td>
                            <td>December</td>
                            <td><input id="price" name="recommend_price[]" maxlength="15"
                                       value="<?php echo $recommend_price[11]; ?>"/></td>
                        </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td><label for="recommend">Recommend:</label></td>
            <td><input id="recommend" name="recommend" value="1" type="checkbox"
                    <?php echo $recommend == 1 ? "checked" : "" ?>/></td>
        </tr>
        <tr>
            <td colspan="2"></td>
        </tr>
        <tr>
            <?php
            if (empty($facilities)) {
                $arrayFacilities = array(0, 0, 0, 0, 0, 0, 0, 0, 0, 0);
            } else {
                $arrayFacilities = explode(',', $facilities);
            }
            ?>
            <td valign="top"><label for="">Facilities :</label></td>
            <td>
                <input type="hidden" id="facilities" name="facilities" value="<?php echo $facilities; ?>">
                <table>
                    <tr>
                        <td><label><input class="facilities"  <?php echo @$arrayFacilities[0] ? 'checked' : ""; ?>
                                          type="checkbox" checked=""> FREE WIFI</label></td>
                        <td><label><input class="facilities"  <?php echo @$arrayFacilities[1] ? 'checked' : ""; ?>
                                          type="checkbox" checked=""> BREAKFAST</label></td>
                        <td><label><input class="facilities"  <?php echo @$arrayFacilities[2] ? 'checked' : ""; ?>
                                          type="checkbox" checked=""> EN-SUITE BATHROOM</label></td>
                    </tr>
                    <tr>
                        <td><label><input class="facilities"  <?php echo @$arrayFacilities[3] ? 'checked' : ""; ?>
                                          type="checkbox" checked=""> FLAT SCREEN TV</label></td>
                        <td><label><input class="facilities"  <?php echo @$arrayFacilities[4] ? 'checked' : ""; ?>
                                          type="checkbox" checked=""> MINI BAR</label></td>
                        <td><label><input class="facilities"  <?php echo @$arrayFacilities[5] ? 'checked' : ""; ?>
                                          type="checkbox">SAFETY DEPOSIT BOX</label></td>
                    </tr>
                    <tr>
                        <td><label><input class="facilities"  <?php echo @$arrayFacilities[6] ? 'checked' : ""; ?>
                                          type="checkbox"> KING SIZE BED</label></td>
                        <td><label><input class="facilities"  <?php echo @$arrayFacilities[7] ? 'checked' : ""; ?>
                                          type="checkbox"> QUEEN SIZE BED</label></td>
                        <td><label><input class="facilities"  <?php echo @$arrayFacilities[8] ? 'checked' : ""; ?>
                                          type="checkbox"> TWIN BED</label></td>
                    </tr>
                    <tr>
                        <td><label><input class="facilities"  <?php echo @$arrayFacilities[9] ? 'checked' : ""; ?>
                                          type="checkbox"> PRIVATE BALCONY</label></td>
                        <td></td>
                        <td></td>
                    </tr>
                </table>
                <!--<input class="facilities"
                       type="checkbox" <?php echo @$arrayFacilities[0] ? 'checked' : ""; ?> /> FREE WIFI</br>
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
-->
                <script>
                    jQuery.noConflict()(".facilities").click(function () {
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
        <tr>
            <td valign="top"><label for="room_plan">Room plan:</label></td>
            <td>
                <input id="room_plan" name="room_plan" value="<?php echo $room_plan; ?>"/>
                <input type="button" value="Upload Image" class="button btn_upload_image"
                       data-tbx-id="room_plan"></br>
                <?php if ($room_plan): ?>
                    <img src="<?php echo $room_plan; ?>" style="height: 200px; margin-top: 10px;"/>
                <?php endif; ?>
            </td>
        </tr>
    </table>
    </p>
<?
}

//add_meta_box( $id, $title, $callback, $page, $context, $priority );
function save_details()
{
    global $post;
//var_dump($_POST);exit;
    update_post_meta($post->ID, "room_plan", trim($_POST["room_plan"]));
    update_post_meta($post->ID, "type", trim($_POST["type"]));
    update_post_meta($post->ID, "size", trim($_POST["size"]));
    update_post_meta($post->ID, "designer", trim($_POST["designer"]));
    update_post_meta($post->ID, "price", trim($_POST["price"]));
    update_post_meta($post->ID, "recommend_price", $_POST["recommend_price"]);
    update_post_meta($post->ID, "recommend", $_POST["recommend"]);
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
//        case "price":
//            echo number_format($custom["price"][0]);
//            break;
        case "recommend":
            echo $custom["recommend"][0] ? '<input type="checkbox" disabled checked/>' : "";
            break;
//        case "category":
//            echo get_the_term_list($post->ID, 'Category', '', ', ', '');
//            break;
    }
}

add_action('init', 'room_register');

register_taxonomy("Category", array("room"), array(
    "hierarchical" => true,
    "label" => "Category",
    "singular_label" => "Category",
    "rewrite" => true
));

add_action("admin_init", "admin_init_room");

global $post;
$custom = get_post_custom($post->ID);
add_action('save_post', 'save_details');
add_action("manage_posts_custom_column", "room_custom_columns");
add_filter("manage_edit-room_columns", "room_edit_columns");

add_theme_support('post-thumbnails');
register_post_type('room', $argc);

//------------------------------- END Room Type Post--------------------------------//
