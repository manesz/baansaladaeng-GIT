<?php
/*
Plugin Name: Test List Table Example
*/
if (!class_exists('WP_List_Table')) {
    require_once(ABSPATH . 'wp-admin/includes/class-wp-list-table.php');
}
if (!class_exists('Booking')) {
    require_once('ClassBooking.php');
}

class Booking_List extends WP_List_Table
{

    var $booking_data = null;
    function __construct()
    {
        global $status, $page, $wpdb;

        parent::__construct(array(
            'singular' => __('book', 'mylisttable'), //singular name of the listed records
            'plural' => __('books', 'mylisttable'), //plural name of the listed records
            'ajax' => true //does this table support ajax?

        ));
        add_action('admin_head', array(&$this, 'admin_header'));

        $classBooking = new Booking($wpdb);
        $this->booking_data = array();
        $result = $classBooking->bookingList();
        foreach ($result as $key => $value) {
            $permalink = get_permalink( $value->room_id );
            $this->booking_data[] = array(
                'id' => $value->id,
                'count' => $key + 1,
                'room_name' => "<a href='$permalink' target='_blank'>$value->room_name</a>",
                'booking_date' => $value->booking_date,
                'name' => "$value->middle_name $value->last_name",
                'passport_no' => $value->passport_no,
                'email' => $value->email,
                'tel' => $value->tel,
                'no_of_person' => $value->no_of_person,
                'need_airport_pickup' => $value->need_airport_pickup ? '<input type="checkbox" checked disabled />'
            :'<input type="checkbox" disabled />',
                'create_time' => $value->create_time,
            );
        }

    }

    function admin_header()
    {
        $page = (isset($_GET['page'])) ? esc_attr($_GET['page']) : false;
        if ('booking_list' != $page)
            return;
        echo '<style type="text/css">';
        echo '.wp-list-table .column-id { width: 5%; }';
        echo '.wp-list-table .column-count { width: 2%; }';
        echo '.wp-list-table .column-room_name { width: 10%; }';
        echo '.wp-list-table .column-booking_date { width: 10%; }';
        echo '.wp-list-table .column-name { width: 10%; }';
        echo '.wp-list-table .column-passport_no { width: 10%; }';
        echo '.wp-list-table .column-email { width: 10%; }';
        echo '.wp-list-table .column-tel { width: 10%; }';
        echo '.wp-list-table .column-no_of_person { width: 10%; }';
        echo '.wp-list-table .column-need_airport_pickup { width: 10%; }';
        echo '.wp-list-table .column-create_time { width: 10%; }';
        echo '</style>';
    }

    function no_items()
    {
        _e('No booking found, dude.');
    }

    function column_default($item, $column_name)
    {
        switch ($column_name) {
            case 'count':
            case 'room_name':
            case 'booking_date':
            case 'name':
            case 'passport_no':
            case 'email':
            case 'tel':
            case 'no_of_person':
            case 'need_airport_pickup':
            case 'create_time':
                return $item[$column_name];
            default:
                return print_r($item, true); //Show the whole array for troubleshooting purposes
        }
    }

    function get_sortable_columns()
    {
        $sortable_columns = array(
//            'count' => array('count', true),
            'room_name' => array('booking_date', true),
            'booking_date' => array('booking_date', true),
            'name' => array('name', true),
            'passport_no' => array('passport_no', false),
            'email' => array('email', false),
//            'tel' => array('tel', false),
//            'no_of_person' => array('no_of_person', false),
//            'need_airport_pickup' => array('need_airport_pickup', false),
            'create_time' => array('create_time', true),
        );
        return $sortable_columns;
    }

    function get_columns()
    {
        $columns = array(
            'cb' => '<input type="checkbox" />',
            'count' => __('#', 'mylisttable'),
            'room_name' => __('Room Name', 'mylisttable'),
            'booking_date' => __('Booking Date', 'mylisttable'),
            'name' => __('Name', 'mylisttable'),
            'passport_no' => __('Passport', 'mylisttable'),
            'email' => __('Email', 'mylisttable'),
            'tel' => __('Tel', 'mylisttable'),
            'no_of_person' => __('Person', 'mylisttable'),
            'need_airport_pickup' => __('Pickup', 'mylisttable'),
            'create_time' => __('Create time', 'mylisttable'),
        );
        return $columns;
    }

    function usort_reorder($a, $b)
    {
        // If no sort, default to title
        $orderby = (!empty($_GET['orderby'])) ? $_GET['orderby'] : 'create_time';
        // If no order, default to asc
        $order = (!empty($_GET['order'])) ? $_GET['order'] : 'desc';
        // Determine sort order
        $result = strcmp($a[$orderby], $b[$orderby]);
        // Send final sort direction to usort
        return ($order === 'desc') ? $result : -$result;
    }

    function column_booktitle($item)
    {
        $actions = array(
            'edit' => sprintf('<a href="?page=%s&action=%s&book=%s">Edit</a>', $_REQUEST['page'], 'edit', $item['id']),
            'delete' => sprintf('<a href="?page=%s&action=%s&book=%s">Delete</a>', $_REQUEST['page'], 'delete', $item['id']),
        );

        return sprintf('%1$s %2$s', $item['create_time'], $this->row_actions($actions));
    }

    function get_bulk_actions()
    {
        $actions = array(
            'delete' => 'Delete'
        );
        return $actions;
    }

    function column_cb($item)
    {
        return sprintf(
            '<input type="checkbox" name="book[]" value="%s" />', $item['id']
        );
    }

    function prepare_items()
    {
        $columns = $this->get_columns();
        $hidden = array();
        $sortable = $this->get_sortable_columns();
        $this->_column_headers = array($columns, $hidden, $sortable);
        usort($this->booking_data, array(&$this, 'usort_reorder'));

        $per_page = 10;
        $current_page = $this->get_pagenum();
        $total_items = count($this->booking_data);

        // only ncessary because we have sample data
        $this->found_data = array_slice($this->booking_data, (($current_page - 1) * $per_page), $per_page);

        $this->set_pagination_args(array(
            'total_items' => $total_items, //WE have to calculate the total number of items
            'per_page' => $per_page //WE have to determine how many items to show on a page
        ));
        $this->items = $this->found_data;
    }

} //class

