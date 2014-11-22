<?php
/**
 * Created by PhpStorm.
 * User: Rux
 * Date: 16/10/2557
 * Time: 14:37 น.
 */


//------------------------------- Booking List--------------------------------//

add_action('admin_menu', 'my_add_booking_menu_na_items');
function my_add_booking_menu_na_items()
{
//    $hook = add_menu_page(
//        'Booking List',
//        'Booking',
//        'activate_plugins',
//        'booking_list',
//        'render_booking_na_page_list' , '', 50
//    );
    $hook = add_submenu_page(
        'ics_theme_settings',
        'Booking List(na)',
        'Booking List(na)',
        'manage_options',
        'booking-list-na',
        'render_booking_na_page_list'
    );
    add_action("load-$hook", 'add_options_booking_menu_na');

}

function add_options_booking_menu_na()
{
    global $myListTable;
    $option = 'per_page';
    $args = array(
        'label' => 'Books',
        'default' => 10,
        'option' => 'books_per_page',
    );
    add_screen_option($option, $args);
    $myListTable = new Booking_List(false);
}

//add_action('admin_menu', 'my_add_booking_menu_items');


function render_booking_na_page_list()
{
    global $myListTable;
        echo '</pre><div class="wrap"><h2>Booking List(na)</h2>';
        $myListTable->prepare_items();
        ?>
        <form method="post">
            <input type="hidden" name="page" value="ttest_list_table">
        <?php
        $myListTable->search_box('search', 'search_id');
        $myListTable->display();
        echo '</form></div>';

}
//------------------------------- End Booking List--------------------------------//