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
        $result = $classBooking->bookingList(0, 0, true);
        foreach ($result as $key => $value) {
            $permalink = get_permalink($value->room_id);
            $checkTimeOut = $classBooking->checkTimeOut($value->pm_create_time, $value->timeout);
            var_dump($checkTimeOut);var_dump($value->paid);
            if ($checkTimeOut && $value->paid != 1) {
                $strShowPaidField = "Time Out";
            } else {
                $strShowPaidField = $value->paid ? '<input type="checkbox" checked onclick="return setApprove(this, ' .
                    $value->payment_id . ');" />'
                    : '<input type="checkbox" onclick="return setApprove(this, ' . $value->payment_id .
                    ');" />';
            }
            $strShowTime = '<div class="clock" date-create="'.
                $value->create_time.'" timeout="'.$value->timeout.'" paid="'.$value->paid. '"></div>';
            $this->booking_data[] = array(
                'id' => $value->id,
                'count' => $key + 1,
                'room_name' => "<a href='$permalink' target='_blank'>$value->room_name</a>",
//                'booking_date' => $value->booking_date,
                'name' => "$value->name $value->last_name",
//                'passport_no' => $value->passport_no,
                'email' => $value->email,
                'tel' => $value->tel,
                'adults' => $value->adults,
                'need_airport_pickup' => $value->need_airport_pickup ? 'YES' : 'NO',
//                'price'=>number_format($value->total),
                'timeout' => $strShowTime,
                'paid' => $strShowPaidField,
                'pm_create_time' => $value->pm_create_time,
                'edit' => '<a href="?page=booking-list&booking-edit=true&id=' . $value->payment_id . '">Edit</a>'
            );
        }

    }

    function admin_header()
    {
        $page = (isset($_GET['page'])) ? esc_attr($_GET['page']) : false;
        if ('booking-list' != $page)
            return;
        ?>
        <style type="text/css">
            .wp-list-table .column-id {
                width: 1%;
            }

            .wp-list-table .column-count {
                width: 1%;
            }

            .wp-list-table .column-room_name {
                width: 10%;
            }

            /*.wp-list-table .column-booking_date { width: 10%; }*/
            .wp-list-table .column-name {
                width: 10%;
            }

            .wp-list-table .column-email {
                width: 15%;
            }

            .wp-list-table .column-tel {
                width: 10%;
            }

            .wp-list-table .column-adults {
                width: 4%;
            }

            .wp-list-table .column-need_airport_pickup {
                width: 4%;
            }

            .wp-list-table .column-timeout {
                width: 10%;
            }
            .wp-list-table .column-paid {
                width: 5%;
            }

            .wp-list-table .column-pm_create_time {
                width: 10%;
            }

            .wp-list-table .column-edit {
                width: 5%;
            }
            .clock {
                zoom: 0.3;
                -moz-transform: scale(0.5)
            }
        </style>
        <script type="text/javascript"
                src="<?php bloginfo('template_directory'); ?>/library/js/booking_edit.js"></script>

        <link rel="stylesheet" href="<?php bloginfo('template_directory'); ?>/library/css/flip-clock/flipclock.css">
        <script src="<?php bloginfo('template_directory'); ?>/library/js/flip-clock/flipclock.js"></script>
    <?php
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
//            case 'booking_date':
            case 'name':
//            case 'passport_no':
            case 'email':
            case 'tel':
            case 'adults':
            case 'need_airport_pickup':
            case 'timeout':
            case 'paid':
            case 'pm_create_time':
            case 'edit':
                return $item[$column_name];
            default:
                return print_r($item, true); //Show the whole array for troubleshooting purposes
        }
    }

    function get_sortable_columns()
    {
        $sortable_columns = array(
//            'count' => array('count', true),
            'room_name' => array('room_name', true),
//            'booking_date' => array('booking_date', true),
            'name' => array('name', true),
//            'passport_no' => array('passport_no', false),
            'email' => array('email', false),
//            'tel' => array('tel', false),
//            'adults' => array('adults', false),
//            'need_airport_pickup' => array('need_airport_pickup', false),
            'pm_create_time' => array('pm_create_time', true),
        );
        return $sortable_columns;
    }

    function get_columns()
    {
        $columns = array(
            'cb' => '<input type="checkbox" />',
            'count' => __('#', 'mylisttable'),
            'room_name' => __('Room Name', 'mylisttable'),
//            'booking_date' => __('Booking Date', 'mylisttable'),
            'name' => __('Name', 'mylisttable'),
//            'passport_no' => __('Passport', 'mylisttable'),
            'email' => __('Email', 'mylisttable'),
            'tel' => __('Tel', 'mylisttable'),
            'adults' => __('Adults', 'mylisttable'),
            'need_airport_pickup' => __('Pickup', 'mylisttable'),
            'timeout' => __('Time Out', 'mylisttable'),
            'paid' => __('Approve', 'mylisttable'),
            'pm_create_time' => __('Create time', 'mylisttable'),
            'edit' => __('Edit', 'mylisttable'),
        );
        return $columns;
    }

    function usort_reorder($a, $b)
    {
        // If no sort, default to title
        $orderby = (!empty($_GET['orderby'])) ? $_GET['orderby'] : 'pm_create_time';
        // If no order, default to asc
        $order = (!empty($_GET['order'])) ? $_GET['order'] : 'desc';
        // Determine sort order
        $result = strcmp($a[$orderby], $b[$orderby]);
        // Send final sort direction to usort
        return ($order === 'asc') ? $result : -$result;
    }

    function column_booktitle($item)
    {
        $actions = array(
            'edit' => sprintf('<a href="?page=%s&action=%s&book=%s">Edit</a>', $_REQUEST['page'], 'edit', $item['id']),
            'delete' => sprintf('<a href="?page=%s&action=%s&book=%s">Delete</a>', $_REQUEST['page'], 'delete', $item['id']),
        );

        return sprintf('%1$s %2$s', $item['pm_create_time'], $this->row_actions($actions));
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

    function bookingEditTemplate()
    {
        global $webSiteName;
        global $wpdb;
        $classBooking = new Booking($wpdb);
        $paymentID = @$_GET['id'];
        $objDataBooking = $classBooking->bookingList($paymentID);
        $arrayRoomName = array();
        $subTotal = 0;
        foreach ($objDataBooking as $key => $value) {
            $needAirPortPickup = $value->need_airport_pickup;
            $subTotal += $value->total;
            $strRoomName = $key + 1 . ". " . $value->room_name . " / " . number_format($value->price) .
                " ฿ | " . date_i18n("d/m/Y", strtotime($value->check_in_date)) .
                " - " . date_i18n("d/m/Y", strtotime($value->check_out_date)) . " | ";
            $strRoomName .= '<input type="checkbox" class="need_airport_pickup" onclick="postNeedAirportPickup(this, ' . $value->booking_id . ');" ';
            $strRoomName .= $needAirPortPickup ? ' value="1" checked/>' : ' value="0" />';
            $strRoomName .= " Need Airport Pickup (THB 1,200 one way)";
//            $strRoomName .= "</br>Adults: <input type='text' value='$value->adults' /></br>";
            $arrayRoomName[] = $strRoomName;
        }
        extract((array)$objDataBooking[0]);
        ?>
        <script type="text/javascript"
                src="<?php bloginfo('template_directory'); ?>/library/js/booking_edit.js"></script>

        <link rel="stylesheet" href="<?php bloginfo('template_directory'); ?>/library/css/flip-clock/flipclock.css">
        <script src="<?php bloginfo('template_directory'); ?>/library/js/flip-clock/flipclock.js"></script>

        <input type="hidden" value="<?php bloginfo('template_directory'); ?>/library/js/jquery.min.js" id="getjqpath"/>
        </pre>
        <div class="wrap">
        <form id="frm_booking" method="post" onsubmit="return false;">
        <input type="hidden" name="booking_post" value="true"/>
        <input type="hidden" name="reservation_post" value="edit_booking"/>
        <input type="hidden" name="payment_id" value="<?php echo $payment_id; ?>"/>
        <input type="hidden" id="booking_id" name="booking_id" value="0"/>
        <input type="hidden" id="payment_need_airport_pickup" name="payment_need_airport_pickup" value=""/>

        <div class="wrap">
        <div id="icon-themes" class="icon32"><br/></div>

        <h2><?php _e(@$webSiteName . ' theme controller', 'wp_toc'); ?></h2>

        <p><?php echo @$webSiteName; ?> business website theme &copy; developer by
            <a href="http://www.ideacorners.com"
               target="_blank">IdeaCorners Developer</a></p>
        <!-- If we have any error by submiting the form, they will appear here -->
        <?php settings_errors('tab1-errors'); ?>
        <h2>Booking Edit</h2>

        <div class="tb-insert">
        <table class="wp-list-table widefat" cellspacing="0" width="100%">
        <tbody id="the-list-edit">
        <tr class="alternate">
            <td><label for="">Room :</label></td>
            <td colspan="3"><?php echo $arrayRoomName ? implode('<br/>', $arrayRoomName) : "No data"; ?></td>
        </tr>
        <tr class="alternate">
            <td><label for="">Sub total :</label></td>
            <td colspan="3"><?php echo number_format($subTotal); ?> ฿</td>
        </tr>
        <tr class="alternate">
            <td><label for="payment_name">Name :<font color="#FF0000">*</font></label></td>
            <td><input type="text" id="payment_name" name="payment_name"
                       value="<?php echo $name; ?>"/></td>
            <td><label for="payment_middle_name">Middle Name :</label></td>
            <td><input type="text" id="payment_middle_name" name="payment_middle_name"
                       value="<?php echo $middle_name; ?>"/></td>
        </tr>
        <tr class="alternate">
            <td><label for="payment_last_name">Last Name :<font color="#FF0000">*</font></label></td>
            <td><input type="text" id="payment_last_name" name="payment_last_name"
                       value="<?php echo $last_name; ?>"/></td>
            <td><label for="payment_date_of_birth_1">Date of Birth :<font color="#FF0000">*</font></label></td>
            <td>
                <?php
                $dobDate = date_i18n('d', strtotime($date_of_birth));
                $dobMonth = date_i18n('m', strtotime($date_of_birth));
                $dobYear = date_i18n('Y', strtotime($date_of_birth));
                ?>
                <select id="payment_date_of_birth_1" name="payment_date_of_birth_1">
                    <option value="">Date</option>
                    <?php for ($i = 1; $i <= 31; $i++): ?>
                        <option <?php echo $i == $dobDate ? 'selected' : ''; ?>
                            value="<?php echo $i; ?>"><?php echo $i; ?></option>
                    <?php endfor; ?>
                </select>&nbsp;/&nbsp;
                <select id="payment_date_of_birth_2" name="payment_date_of_birth_2">
                    <option value="">Month</option>
                    <?php for ($i = 1; $i <= 12; $i++): ?>
                        <option <?php echo $i == $dobMonth ? 'selected' : ''; ?>
                            value="<?php echo $i; ?>"><?php echo $i; ?></option>
                    <?php endfor; ?>
                </select>&nbsp;/&nbsp;
                <select id="payment_date_of_birth_3" name="payment_date_of_birth_3">
                    <option value="">Year</option>
                    <?php for ($i = date_i18n("Y") - 95; $i <= date_i18n("Y") - 12; $i++): ?>
                        <option <?php echo $i == $dobYear ? 'selected' : ''; ?>
                            value="<?php echo $i; ?>"><?php echo $i; ?></option>
                    <?php endfor; ?>
                </select>
            </td>
        </tr>
        <tr class="alternate">
            <td><label for="payment_passport_no">Passport No. :<font color="#FF0000">*</font></label></td>
            <td><input type="text" id="payment_passport_no" name="payment_passport_no"
                       value="<?php echo $passport_no; ?>"/></td>
            <td><label for="payment_nationality">Nationality :<font color="#FF0000">*</font></label></td>
            <td><input type="text" id="payment_nationality" name="payment_nationality"
                       value="<?php echo $nationality; ?>"/>
            </td>
        </tr>
        <tr class="alternate">
            <td><label for="payment_email">Email :<font color="#FF0000">*</font></label></td>
            <td><input type="text" id="payment_email" name="payment_email"
                       value="<?php echo $email; ?>"/></td>
            <td><label for="payment_date_of_birth_1">Estimated arrival Time :<font
                        color="#FF0000">*</font></label></td>
            <td>
                <?php
                $expEst = explode(':', $estimated_arrival_time);
                $estArrival1 = $expEst[0];
                $estArrival2 = $expEst[1];
                $estArrival3 = $expEst[2];
                ?>
                <select id="payment_est_arrival1" name="payment_est_arrival1" class="">
                    <option value="">--</option>
                    <?php for ($i = 1; $i <= 12; $i++): ?>
                        <option <?php echo $i == $estArrival1 ? 'selected' : ''; ?>
                            value="<?php echo $i; ?>"><?php echo $i; ?></option>
                    <?php endfor; ?>
                </select>&nbsp;:&nbsp;
                <select id="payment_est_arrival2" name="payment_est_arrival2" class="">
                    <option value="">--</option>
                    <option <?php echo '00' == $estArrival2 ? 'selected' : ''; ?>
                        value="00">00
                    </option>
                    <option <?php echo '15' == $estArrival2 ? 'selected' : ''; ?>
                        value="15">15
                    </option>
                    <option <?php echo '30' == $estArrival2 ? 'selected' : ''; ?>
                        value="30">30
                    </option>
                    <option <?php echo '45' == $estArrival2 ? 'selected' : ''; ?>
                        value="45">45
                    </option>
                </select>&nbsp;:&nbsp;
                <select id="payment_est_arrival3" name="payment_est_arrival3" class="">
                    <option value="">----</option>
                    <option <?php echo 'AM' == $estArrival3 ? 'selected' : ''; ?>
                        value="AM">AM
                    </option>
                    <option <?php echo 'PM' == $estArrival3 ? 'selected' : ''; ?>
                        value="PM">PM
                    </option>
                </select>
            </td>
        </tr>
        <tr class="alternate">
            <td><label for="payment_tel">Tel/Mobile Number :</label></td>
            <td><input type="text" id="payment_tel" name="payment_tel"
                       value="<?php echo $tel; ?>"/></td>
            <td><label for="payment_no_of_person">No. of Person :<font color="#FF0000">*</font></label></td>
            <td><select id="payment_no_of_person" name="payment_no_of_person">
                    <option value="">---- Select ----</option>
                    <option <?php echo $no_of_person == 0 ? "selected" : ""; ?> value="0">0</option>
                    <option <?php echo $no_of_person == 1 ? "selected" : ""; ?> value="1">1</option>
                    <option <?php echo $no_of_person == 2 ? "selected" : ""; ?> value="2">2</option>
                </select>
            </td>
        </tr>
        <tr class="alternate">
            <td><label for="payment_note">Note :</label></td>
            <td colspan="3"><textarea id="payment_note" name="payment_note"
                                      style="margin: 0px; width: 236px; height: 71px;"><?php echo $note; ?></textarea>
            </td>
        </tr>
        <tr class="alternate">
            <td></td>
            <td colspan="3"><h3>Credit Card Payment</h3></td>
        </tr>
        <tr class="alternate">
            <td><label for="card_type">Card Type :<font color="#FF0000">*</font></label></td>
            <td>
                <select id="card_type" name="card_type" class="form-control col-md-12">
                    <option value="">---- Select Card ----</option>
                    <option <?php echo $card_type == "Visa" ? "selected" : ""; ?> value="Visa">Visa</option>
                    <option <?php echo $card_type == "Master Card" ? "selected" : ""; ?> value="Master Card">
                        Master Card
                    </option>
                </select>
            </td>
            <td><label for="card_holder_name">Card Holder's Name :<font color="#FF0000">*</font></label></td>
            <td><input type="text" id="card_holder_name" name="card_holder_name"
                       value="<?php echo $card_holder_name; ?>"/></td>
        </tr>
        <tr class="alternate">
            <td><label for="card_number">Card No. :<font color="#FF0000">*</font></label></td>
            <td>
                <input type="text" id="card_number" name="card_number"
                       value="<?php echo $card_number; ?>"/>
            </td>
            <td><label for="tree_digit_id">3-Digit ID# :<font color="#FF0000">*</font></label></td>
            <td><input type="text" id="tree_digit_id" name="tree_digit_id"
                       value="<?php echo $tree_digit_id; ?>" maxlength="3"/></td>
        </tr>
        <tr class="alternate">
            <td><label for="card_number">Card Expiry Date :<font color="#FF0000">*</font></label></td>
            <td colspan="3">
                <?php
                $expCardExp = explode("/", $card_expiry_date);
                $card_expiry_date1 = $expCardExp[0];
                $card_expiry_date2 = $expCardExp[1];
                ?>
                <select id="card_expiry_date1" name="card_expiry_date1">
                    <option value="">-- Month --</option>
                    <?php for ($i = 1; $i <= 12; $i++):
                        $strMonthCardExp = strlen($i) == 1 ? "0$i" : $i;
                        ?>
                        <option <?php echo $card_expiry_date1 == $strMonthCardExp ? "selected" : ""; ?>
                            value="<?php echo $strMonthCardExp ?>"><?php echo $i; ?></option>
                    <?php endfor; ?>
                </select>&nbsp;/&nbsp;
                <select id="card_expiry_date2" name="card_expiry_date2">
                    <option value="">-- Year --</option>
                    <?php for ($i = date_i18n('Y'); $i <= date_i18n("Y") + 20; $i++): ?>
                        <option value="<?php
                        $strY = substr($i, 2);
                        echo $strY = strlen($strY) == 1 ? "0$strY" : $strY; ?>"
                            <?php echo $card_expiry_date2 == $strY ? "selected" : ""; ?>
                            ><?php echo $i; ?></option>
                    <?php endfor; ?>
                </select>
            </td>
        </tr>
        <tr>
        <tr class="alternate">
            <td></td>
            <td colspan="3"><h3>Payment Approve</h3></td>
        </tr>
        <tr>
            <td><label for="paid">Approve :</label></td>
            <td>
                <input type="checkbox" id="paid" name="paid"
                       value="<?php echo $paid; ?>" <?php echo $paid ? "checked" : ""; ?>
                       onclick="return setApprove(this, <?php echo $payment_id; ?>);"/>
            </td>
            <td colspan="3"><label for="time_left">Time Left :</label>

                <div class="clock"></div>
            </td>
            <script type="text/javascript">
                //                                var interval = setInterval(oneSecondFunction, 1000);
                var paid = <?php echo $paid; ?>;
                var time_left_hour = <?php echo $timeout; ?>;
                var create_time = '<?php echo $create_time; ?>';
                $(function () {
                    oneSecondFunction()
                });

                function oneSecondFunction() {
                    var dateNow = new Date();
                    var dateCreate = new Date(create_time);
                    var strToTime = time_left_hour * 60 * 60;
                    var diff = Math.round(dateNow.getTime() / 1000 - dateCreate.getTime() / 1000);
                    diff = strToTime - diff;
                    if (diff < 0 || paid) {
                        diff = 0;
                    }
                    var clock = $('.clock').FlipClock(diff, {
                        countdown: true,
                        clockFace: 'HourCounter'
                    });
                }
            </script>
        </tr>
        <tr>
            <td><label for="time_out">Time Out :</label></td>
            <td colspan="3">
                <input type="text" id="time_out" name="time_out"
                       value="<?php echo $timeout; ?>"/> Hour
            </td>
        </tr>
        </tbody>
        </table>
        <input type="button" class="button-primary" value="Back"
               onclick="window.location.href='?page=booking-list';"> &nbsp;
        <input type="submit" class="button-primary" value="Save">
        </div>
        </div>
        </form>
        </div>
    <?php
    }

} //class

