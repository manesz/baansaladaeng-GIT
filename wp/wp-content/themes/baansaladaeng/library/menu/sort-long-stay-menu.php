<?php
/**
 * User: Rux
 * Date: 30/12/2557
 * Time: 20:30 น.
 */

function add_sort_long_stay_menu_items()
{
    add_submenu_page(
        'ics_theme_settings',
        'Sort Long Stay',
        'Sort Long Stay',
        'manage_options',
        'sort_long_stay',
        'render_sort_long_stay_page'
    );
}


add_action('admin_menu', 'add_sort_long_stay_menu_items');

function ajax_save_sort_long_stay()
{
    global $wpdb;

    parse_str($_POST['order'], $data);
    if (is_array($data))
        foreach ($data as $key => $values) {
            if ($key == 'item') {
                foreach ($values as $position => $id) {
                    $data = array('menu_order' => $position, 'post_parent' => 0);
                    $data = apply_filters('post-types-order_save-ajax-order', $data, $key, $id);

                    $wpdb->update($wpdb->posts, $data, array('ID' => $id));
                }
            } else {
                foreach ($values as $position => $id) {
                    $data = array('menu_order' => $position, 'post_parent' => str_replace('item_', '', $key));
                    $data = apply_filters('post-types-order_save-ajax-order', $data, $key, $id);

                    $wpdb->update($wpdb->posts, $data, array('ID' => $id));
                }
            }
        }
}

function long_stay_list_pages($args = '')
{
    $defaults = array(
        'depth' => 0, 'show_date' => '',
        'date_format' => get_option('date_format'),
        'child_of' => 0, 'exclude' => '',
        'title_li' => __('Pages'), 'echo' => 1,
        'authors' => '', 'sort_column' => 'menu_order',
        'link_before' => '', 'link_after' => '', 'walker' => ''
    );

    $r = wp_parse_args($args, $defaults);
    extract($r, EXTR_SKIP);

    $output = '';

    $r['exclude'] = preg_replace('/[^0-9,]/', '', $r['exclude']);
    $exclude_array = ($r['exclude']) ? explode(',', $r['exclude']) : array();
    $r['exclude'] = implode(',', apply_filters('wp_list_pages_excludes', $exclude_array));

    // Query pages.
    $r['hierarchical'] = 0;
    $args = array(
        'sort_column' => 'menu_order',
        'post_type' => $post_type,
        'posts_per_page' => -1,
        'orderby' => 'menu_order',
        'order' => 'ASC',
        'category_name' => 'long-stay',
    );

    $the_query = new WP_Query($args);
    $pages = $the_query->posts;

    if (!empty($pages)) {
        if ($r['title_li'])
            $output .= '<li class="pagenav intersect">' . $r['title_li'] . '<ul>';

        $output .= long_stay_walk_tree($pages, $r['depth'], $r);

        if ($r['title_li'])
            $output .= '</ul></li>';
    }

    $output = apply_filters('wp_list_pages', $output, $r);

    if ($r['echo'])
        echo $output;
    else
        return $output;
    return true;
}

function long_stay_walk_tree($pages, $depth, $r)
{
    if (empty($r['walker']))
        $walker = new Post_Types_Order_Walker;
    else
        $walker = $r['walker'];

    $args = array($pages, $depth, $r);
    return call_user_func_array(array(&$walker, 'walk'), $args);
}

function render_sort_long_stay_page()
{
    global $objClassContact;
//    if ( $this->current_post_type != null )
//    {
//        wp_enqueue_script('jQuery');
    wp_enqueue_script('jquery-ui-sortable');
//    }

    ?>
    <style>
        #order-post-type #sortable { list-style-type: none; margin: 10px 0 0; padding: 0; width: 100%; }
        #order-post-type #sortable ul { margin-left:20px; list-style: none; }
        #order-post-type #sortable li { padding: 2px 0px; margin: 4px 0px;  border: 1px solid #DDDDDD; cursor: move; -moz-border-radius:6px;}
        #order-post-type #sortable li span { display: block; background: #f9f8f8;  padding: 5px 10px; color:#555; font-size:13px; font-weight:bold;}
        #order-post-type #sortable li.placeholder{border: dashed 2px #ccc;height:25px;}
        #order-post-type {
            width: 50%;
        }

        #icon-settings {background-image:url("../images/admin-icon-settings.gif");background-repeat:no-repeat;}
        h2.subtitle {font-size: 15px; font-style: italic; font-weight: bold}
        .wrap .example { color: #666666; font-size: 11px; font-weight: bold}

        #cpt_info_box {padding: 0 10px; border: 1px dashed #6aadcc; background-color: #FFF; margin-top: 10px;
            -webkit-box-shadow: 1px 1px 7px rgba(50, 50, 50, 0.17);
            -moz-box-shadow:    1px 1px 7px rgba(50, 50, 50, 0.17);
            box-shadow:         1px 1px 7px rgba(50, 50, 50, 0.17);}
        #cpt_info_box p {font-size: 12px}
        #cpt_info_box a {text-decoration: none}
        #cpt_info_box #donate_form {float: right;    padding: 10px 0 17px;    text-align: center;    width: 100%;}
        .menu_pto {margin-right: 4px; display: inline; vertical-align: middle; margin-top: -1px;}

        #p_right {float: right; width: 210px; background-color:#f5f5f5; border-left: 1px dashed #dedede; border-right: 1px dashed #dedede}
        .p_s_item {float: right; padding: 0px 5px; margin-top: 15px; margin-bottom: 5px; }
        .p_s_item.s_gp {padding-top: 2px; margin-left: 5px}

        .clear {clear: both}
    </style>
        <div class="wrap">
            <div class="icon32" id="icon-edit"><br></div>
            <h2>Long Stay - Re-Order</h2>

            <div id="ajax-response"></div>

            <noscript>
                &lt;div class="error message"&gt;
                &lt;p&gt;This plugin can't work without javascript, because it's use drag and drop and AJAX.&lt;/p&gt;
                &lt;/div&gt;
            </noscript>

            <div id="order-post-type">
                <ul id="sortable" class="ui-sortable">
                    <?php long_stay_list_pages('hide_empty=0&title_li=&post_type=room'); ?>
                </ul>
                <div class="clear"></div>
            </div>

            <p class="submit">
                <a href="#" id="save-order" class="button-primary">Update</a>
            </p>

            <script type="text/javascript">
                jQuery(document).ready(function () {
                    jQuery("#sortable").sortable({
                        'tolerance': 'intersect',
                        'cursor': 'pointer',
                        'items': 'li',
                        'placeholder': 'placeholder',
                        'nested': 'ul'
                    });

                    jQuery("#sortable").disableSelection();
                    jQuery("#save-order").bind("click", function () {
//                        alert(jQuery("#sortable").sortable("serialize"));
                        jQuery.post(ajaxurl, {
                            action: 'update-sort-long-stay',
                            order: jQuery("#sortable").sortable("serialize") }, function (result) {
                            jQuery("#ajax-response").html('<div class="message updated fade">' +
                                '<p>Items Order Updated</p></div>');
                            jQuery("#ajax-response div").delay(3000).hide("slow");
                        });
                    });
                });
            </script>
        </div>
<?php
}

if ($_REQUEST) {
    if ($_REQUEST['action'] == 'update-sort-long-stay') {
        ajax_save_sort_long_stay();
        exit;
    }
}