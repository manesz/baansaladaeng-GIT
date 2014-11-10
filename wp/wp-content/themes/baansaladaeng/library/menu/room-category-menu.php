<?php
/**
 * Created by PhpStorm.
 * User: Rux
 * Date: 16/10/2557
 * Time: 15:22 น.
 */
function add_category_room()
{
//    add_submenu_page(
//        'ics_theme_settings',
//        'Category',
//        'Category',
//        'manage_options',
//        'category-list',
//        'edit-tags.php?taxonomy=category'
//    );
    add_submenu_page('ics_theme_settings', 'Category', 'Category', 'manage_options',
        'edit-tags.php?taxonomy=Category&post_type=room',  '' );
}

//add_action("admin_init", "add_category_room");