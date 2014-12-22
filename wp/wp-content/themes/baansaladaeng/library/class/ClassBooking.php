<?php

if (!session_id())
    session_start();

class Booking
{
    private $wpdb;
    private $tableBooking = "ics_booking";
    private $tablePayment = "ics_payment";
    private $tablePost = "wp_posts";

    public function __construct($wpdb)
    {
        $this->wpdb = $wpdb;
    }

    public function bookingList($payment_id = 0, $booking_id = 0, $group_payment_id = false, $room_id = 0)
    {
//        $strAnd = $is_checkout ? "AND a.checkout_time = '0000-00-00 00:00:00'" : "";
        $strAnd = $payment_id ? "AND a.id = $payment_id" : "";
        $strAnd .= $booking_id ? "AND b.id = $booking_id" : "";
        $strAnd .= $room_id ? "AND b.room_id = $room_id" : "";
        $strGroup = $group_payment_id ? " GROUP BY a.id" : "";
//        $strAnd .= $room_id ? "AND b.room_id = $room_id" : "";
        $sql = "
            SELECT
              a.*,
              b.`id` AS booking_id,
              a.`id` AS payment_id,
              b.*,
              c.post_title AS room_name,
              a.create_time AS pm_create_time
            FROM
              `$this->tablePayment` a
              INNER JOIN `$this->tableBooking` b
                ON (
                  a.`id` = b.`payment_id`
                  AND b.`publish` = 1
                )
              INNER JOIN `$this->tablePost` c
                ON (
                  b.room_id = c.ID
                )
            WHERE 1
              AND a.`publish` = 1
              $strAnd
              AND YEAR(a.create_time) >= YEAR(NOW())
            $strGroup
        ";
        $myrows = $this->wpdb->get_results($sql);
        return $myrows;
    }

    public function getRoomByDateCheckInCheckOut($check_in, $check_out, $room_id = 0)
    {
        $strAnd = $room_id ? " AND a.room_id=$room_id" : "";
        if ($check_in && $check_out) {
            $strAnd .= $check_in == $check_out ?
                " AND a.check_in_date='$check_in'
            AND a.check_out_date='$check_out'" :
                " AND (
                a.`check_in_date`
                AND a.`check_out_date` BETWEEN '$check_in'
                AND '$check_out'
              )";
        }
        $sql = "
            SELECT
              a.*,
              b.paid,
              b.timeout,
              b.create_time as pm_create_time
            FROM
              `$this->tableBooking` a
              INNER JOIN $this->tablePayment b
              ON (
                a.payment_id = b.id
                AND b.`publish` = 1)
            WHERE 1
              AND a.`publish` = 1
              $strAnd
        ";
        $rows = $this->wpdb->get_results($sql);
        return $rows;
    }

    public function checkRoom($post)
    {
        extract($post);
//        if (!preg_match('/^[0-9]{4}-[0-9]{2}-[0-9]{2}|[0-9]{1}$/', $check_in)) {
//            $dateCheckIn = explode('/', $check_in);//DateTime::createFromFormat('d/m/Y', $check_in);
//            $dateCheckOut = explode('/', $check_out);
//            echo $check_in = $dateCheckIn[2] . "-".$dateCheckIn[1] . "-".$dateCheckIn[0];
//            $check_out = $dateCheckOut[2] . "-".$dateCheckOut[1] . "-".$dateCheckOut[0];
//        }
        list($dd,$mm,$yyyy) = explode('/',$check_in);
        if (checkdate($mm,$dd,$yyyy)) {
            $dateCheckIn = explode('/', $check_in);//DateTime::createFromFormat('d/m/Y', $check_in);
            $dateCheckOut = explode('/', $check_out);
            $check_in = $dateCheckIn[2] . "-".$dateCheckIn[1] . "-".$dateCheckIn[0];
            $check_out = $dateCheckOut[2] . "-".$dateCheckOut[1] . "-".$dateCheckOut[0];
        }
        $checkIn = date_i18n("Y-m-d", strtotime($check_in));
        $checkOut = date_i18n("Y-m-d", strtotime($check_out));
        $dateNow = date_i18n("Y-m-d");
        if ($checkIn < $dateNow || $checkOut < $dateNow)
            return false;
        $roomId = empty($room_id) ? 0 : $room_id;
        $result = $this->getRoomByDateCheckInCheckOut($checkIn, $checkOut, $roomId);
        if (count($result) > 0) {
            $getPaid = $result[0]->paid;
            if ($getPaid) {
                return false;
            }
            $getDateCreate = $result[0]->create_time;
            $getTimeOut = $result[0]->timeout;
            if ($this->checkTimeOut($getDateCreate, $getTimeOut)) {
                return true;
            }
            return false;
        } else {
            return true;
        }
    }

    /**
     * Check ว่าหมดเวลาจองแล้วหรือยัง
     * @param $create_time
     * @param $time_out
     * @return bool
     */
    public function checkTimeOut($create_time, $time_out)
    {
        return false; //ยกเลิก time out
        $dateNow = date_i18n("Y-m-d H:i:s");
        $timeDiff = abs(strtotime($dateNow) - strtotime($create_time));
        $numberHours = $timeDiff / (60 * 60);
        $numberHours = ceil($numberHours);
        if ($numberHours < $time_out) {
            return false;
        } else {
            return true;
        }
    }

    private function bookingAdd($data)
    {
        $roomID = @$data['room_id'];
        $roomName = @$data['room_name'];
        $arrivalDate = @$data['arrival_date'];
        $departureDate = @$data['departure_date'];
        $payment_id = @$data['payment_id'];
        $price = @$data['price'];
        $needAirportPickup = @$data['need_airport_pickup'];
        $result = $this->getRoomByDateCheckInCheckOut($arrivalDate,
            $departureDate, $roomID);
        if ($result) {
            return "Sorry, $roomName customer request.";
        }
        $timeDiff = abs(strtotime($departureDate) - strtotime($arrivalDate));
        $numberDays = $timeDiff / 86400;
        $numberDays = ceil($numberDays);
        $total = ($numberDays + 1) * $price;
        $total += $needAirportPickup ? 1200 : 0;

        $result = $this->wpdb->insert(
            $this->tableBooking,
            array(
                'room_id' => $roomID,
                'payment_id' => $payment_id,
                'check_in_date' => $arrivalDate,
                'check_out_date' => $departureDate,
                'need_airport_pickup' => $needAirportPickup,
                'price' => $price,
                'total' => $total,
                'create_time' => date_i18n('Y-m-d H:i:s'),
                'update_time' => '0000-00-00 00:00:00',
                'publish' => 1
            ),
            array(
                '%d',
                '%d',
                '%s',
                '%s',
                '%d',
                '%d',
                '%d',
                '%s',
                '%s',
                '%d'
            )
        );
        if (!$result) {
            return 'fail';
        }
        return $result;
    }

    public function bookingEdit($data)
    {
        extract($data);
        if (!@$booking_id)
            return true;

        $result = $this->updateBookingTotal($booking_id, @$payment_need_airport_pickup);
        if (!$result) {
            return 'booking update total fail';
        }
        return true;
    }

    public function paymentEdit($data)
    {
        extract($data);
        $date_of_birth = "$payment_date_of_birth_3-$payment_date_of_birth_2-$payment_date_of_birth_1";
        $estimated_arrival_time = "$payment_est_arrival1:$payment_est_arrival2:$payment_est_arrival3";
        $card_expiry_date = "$card_expiry_date1/$card_expiry_date2";
        $paidTime = @$paid ? date_i18n('Y-m-d H:i:s') : null;
        $result = $this->wpdb->update(
            $this->tablePayment,
            array(
                'name' => @$payment_name,
                'middle_name' => @$payment_middle_name,
                'last_name' => @$payment_last_name,
                'date_of_birth' => @$date_of_birth,
                'passport_no' => @$payment_passport_no,
                'nationality' => @$payment_nationality,
                'email' => @$payment_email,
                'estimated_arrival_time' => @$estimated_arrival_time,
                'tel' => @$payment_tel,
                'note' => @$payment_note,
                'card_type' => @$card_type,
                'card_holder_name' => @$card_holder_name,
                'card_number' => @$card_number,
                'tree_digit_id' => @$tree_digit_id,
                'card_expiry_date' => @$card_expiry_date,
                'update_time' => date_i18n('Y-m-d H:i:s'),
                'paid_time' => $paidTime,

                'no_of_person' => @$payment_no_of_person,
                'timeout' => @$time_out,
                'paid' => @$paid,
                'publish' => 1
            ),
            array('id' => $payment_id),
            array(
                '%s',
                '%s',
                '%s',
                '%s',
                '%s',
                '%s',
                '%s',
                '%s',
                '%s',
                '%s',
                '%s',
                '%s',
                '%s',
                '%s',
                '%s',
                '%s',
                '%s',

                '%d',
                '%d',
                '%d',
                '%d',
            ),
            array('%d')
        );
        if (!$result) {
            return "payment fail";
        }
        return true;
    }

    public function paymentAdd($data)
    {
        extract($data);
//        $card_expiry_date = "$card_expiry_date1/$card_expiry_date2";
        $payment_id = empty($payment_id) ? 0 : $payment_id;
        $payment_date_of_birth_3 = empty($payment_date_of_birth_3) ? "" : $payment_date_of_birth_3;
        $payment_date_of_birth_2 = empty($payment_date_of_birth_2) ? "" : $payment_date_of_birth_2;
        $payment_date_of_birth_1 = empty($payment_date_of_birth_1) ? "" : $payment_date_of_birth_1;
        $payment_est_arrival1 = empty($payment_est_arrival1) ? "" : $payment_est_arrival1;
        $payment_est_arrival2 = empty($payment_est_arrival2) ? "" : $payment_est_arrival2;
        $payment_est_arrival3 = empty($payment_est_arrival3) ? "" : $payment_est_arrival3;
        $card_expiry_date1 = empty($card_expiry_date1) ? "" : $card_expiry_date1;
        $card_expiry_date2 = empty($card_expiry_date2) ? "" : $card_expiry_date2;
        $date_of_birth = "$payment_date_of_birth_3-$payment_date_of_birth_2-$payment_date_of_birth_1";
        $estimated_arrival_time = "$payment_est_arrival1:$payment_est_arrival2:$payment_est_arrival3";
        $card_expiry_date = "$card_expiry_date1/$card_expiry_date2";
        $arrayDataQuery = array(
            'name' => empty($payment_name) ? "" : $payment_name,
            'middle_name' => empty($payment_middle_name) ? "" : $payment_middle_name,
            'last_name' => empty($payment_last_name) ? "" : $payment_last_name,
            'date_of_birth' => empty($date_of_birth) ? "" : $date_of_birth,
            'passport_no' => empty($payment_passport_no) ? "" : $payment_passport_no,
            'nationality' => empty($payment_nationality) ? "" : $payment_nationality,
            'email' => empty($payment_email) ? "" : $payment_email,
            'estimated_arrival_time' => empty($estimated_arrival_time) ? "" : $estimated_arrival_time,
            'tel' => empty($payment_tel) ? "" : $payment_tel,
            'note' => empty($payment_note) ? "" : $payment_note,
            'card_type' => empty($card_type) ? "" : $card_type,
            'card_holder_name' => empty($card_holder_name) ? "" : $card_holder_name,
            'card_number' => empty($card_number) ? "" : $card_number,
            'tree_digit_id' => empty($tree_digit_id) ? "" : $tree_digit_id,
            'card_expiry_date' => empty($card_expiry_date) ? "" : $card_expiry_date,
            'no_of_person' => empty($payment_no_of_person) ? "" : $payment_no_of_person,
        );
        $arrayTypeDataQuery = array(
            '%s',
            '%s',
            '%s',
            '%s',
            '%s',
            '%s',
            '%s',
            '%s',
            '%s',
            '%s',
            '%s',
            '%s',
            '%s',
            '%s',
            '%s',
            '%d',
            '%s',
            '%s',
            '%d',
        );
        $sessionGet = $_SESSION['array_reservation_order'];
        $payment_id = empty($sessionGet['payment_id']) ? 0 : $sessionGet['payment_id'];
        if ($payment_id) {
            $arrayDataQuery['update_time'] = date_i18n('Y-m-d H:i:s');
            $arrayDataQuery['publish'] = 1;
            $arrayTypeDataQuery[count($arrayTypeDataQuery)] = '%s';
            $arrayTypeDataQuery[count($arrayTypeDataQuery)] = '%d';
            $result = $this->wpdb->update(
                $this->tablePayment,
                $arrayDataQuery,
                array('id' => $payment_id),
                $arrayTypeDataQuery,
                array('%d')

            );
            if (!$result)
                return false;
            $_SESSION['array_reservation_order'] = array();
            return true;
        } else {
            $arrayDataQuery['create_time'] = date_i18n('Y-m-d H:i:s');
            $arrayDataQuery['update_time'] = '0000-00-00 00:00:00';
            $arrayDataQuery['publish'] = 1;
            $arrayTypeDataQuery[count($arrayTypeDataQuery)] = '%s';
            $arrayTypeDataQuery[count($arrayTypeDataQuery)] = '%s';
            $arrayTypeDataQuery[count($arrayTypeDataQuery)] = '%d';
            $result = $this->wpdb->insert(
                $this->tablePayment,
                $arrayDataQuery
                ,
                $arrayTypeDataQuery
            );
            if ($result) {
                return $this->wpdb->insert_id;
            }
        }

        return false;
    }

    public function updateBookingTotal($booking_id, $need_airport_pickup_new)
    {
        $objData = $this->bookingList(0, $booking_id);
        if ($objData) {
            extract((array)$objData[0]);
            $needAirportPickUpBath = @$need_airport_pickup_new ? 1200 : 0;
            $timeDiff = abs(strtotime($check_in_date) - strtotime($check_out_date));
            $numberDays = $timeDiff / 86400;
            $numberDays = ceil($numberDays);
            $total = ($numberDays + 1) * $price;
            $total = $total + $needAirportPickUpBath;
            $result = $this->wpdb->update(
                $this->tableBooking,
                array(
                    'total' => $total,
                    'need_airport_pickup' => $need_airport_pickup_new,
                    'update_time' => date_i18n('Y-m-d H:i:s'),
                ),
                array('id' => $booking_id),
                array(
                    '%d',
                    '%s',
                    '%s'
                ),
                array('%d')
            );
            if (!$result) {
                return false;
            }

        }
        return true;
    }

    function groupArrayDate($array_date)
    {
        //$datearray = array("2013-05-05", "2013-05-06", "2013-05-07", "2013-05-08", "2013-06-19", "2013-06-20", "2013-06-21");
//        asort($array_date);
        $resultArray = array();
        $index = -1;
        $last = 0;
        $out = "";
        $arrSaveDate = array();
        $arrDateSort1 = array();
        $arrDateSort2 = array();

        foreach ($array_date as $sort1) {
            $expDate = explode('|', $sort1);
            $arrDateSort1[] = date("Y-m-d", strtotime($expDate[0]));
        }
        asort($arrDateSort1);

        foreach ($arrDateSort1 as $sort1) {
            foreach($array_date as $sort2) {
                $expDate = explode('|', $sort2);
                if (date("Y-m-d", strtotime($expDate[0])) == $sort1) {
                    $arrDateSort2[] = date("Y-m-d", strtotime($expDate[0])) . "|". date("Y-m-d", strtotime($expDate[1]));
                }
            }
        }
        $array_date = $arrDateSort2;
        foreach ($array_date as $date) {
            $expDate = explode('|', $date);
            if ($expDate[0] == $expDate[1]) {
                $ts = strtotime($expDate[0]);
                if (false !== $ts) {
                    $diff = $ts - $last;

                    if ($diff > 86400) {
                        $index = $index + 1;
                        $resultArray[$index][] = $expDate[0];
                    } elseif ($diff > 0) {
                        $resultArray[$index][] = $expDate[0];
                    } else {
                        // Error! dates are not in order from small to large
                    }
                    $last = $ts;
                }
            } else {
                $arrSaveDate[] = $date;
            }
        }
        foreach ($resultArray as $a) {
            if (count($a) > 1) {
                $firstDate = $a[0];
                $firstDateBits = explode('-', $firstDate);
                $lastDate = $a[count($a) - 1];
                $lastDateBits = explode('-', $lastDate);
                /*
                        if ($firstDateBits[1] === $lastDateBits[1]) {
                            $out .= intval($firstDateBits[2]) . '-' . intval($lastDateBits[2]) . ' ' . date("m",strtotime($firstDate)) . ', ';
                        } else {
                            $out .= date("Y-m-d",strtotime($firstDate)) . '-' . date("Y-m-d",strtotime($lastDate)) . ', ';
                        }*/
                $arrSaveDate[] = $firstDate . "|" . $lastDate;
            } else {
                $arrSaveDate[] = $a[0] . "|" . $a[0];
            }
        }
        return $arrSaveDate;
    }

    function addArrayBooking($post)
    {
        if (!@$post['array_booking'] || !@$post['room_id'])
            return false;
        if ($post['array_booking']) {
            $newGroupDate = $this->groupArrayDate($post['array_booking']);

            foreach ($newGroupDate as $key => $value) {
                $expDate = explode('|', $value);
                $checkInDate = $expDate[0];
                $checkOutDate = $expDate[1];
                $post['arrival_date'] = $checkInDate;
                $post['departure_date'] = $checkOutDate;
                $post['need_airport_pickup'] = 0;
                $result = $this->addSessionOrder($post);
                if ($result != true) {
                    return $result;
                }
            }
        }
        return true;
    }

    function addSessionOrder($post)
    {
//        $arrayOrder = @$_SESSION['array_reservation_order'];
        $roomID = @$post['room_id'];
        $query = new WP_Query(array(
            'post_type' => 'room',
            'post__in' => array($roomID)
        ));
        $posts = $query->get_posts();
        $customField = get_post_custom($roomID);
        $roomPrice = empty($customField["price"][0]) ? 0: $customField["price"][0];
        $roomName = @$posts[0]->post_title;
        $recommend_price = get_post_meta($roomID, 'recommend_price', true);
        $recommend_price = is_array($recommend_price) ? @$recommend_price[intval(date_i18n('m')) - 1] : null;

//        $arrivalDate = $post['arrival_date'];
//        $departureDate = $post['departure_date'];
//        $needAirportPickup = $post['need_airport_pickup'];
//        $timeDiff = abs(strtotime($departureDate) - strtotime($arrivalDate));
//        $numberDays = $timeDiff / 86400;
//        $total = $numberDays * $roomPrice;

//        $arrayOrder[] = array(
//            'room_id' => $roomID,
//            'room_name' => $roomName,
//            'arrival_date' => @$arrivalDate,
//            'departure_date' => @$departureDate,
//            'adults' => @$post['adults'],
//            'price' => $roomPrice,
//            'need_airport_pickup' => $needAirportPickup,
//        );
//        $_SESSION['array_reservation_order'] = $arrayOrder;


        $arrayOrder = @$_SESSION['array_reservation_order'];
        $payment_id = empty($arrayOrder['payment_id']) ? 0 : $arrayOrder['payment_id'];

        if (!$payment_id) {
            $payment_id = $this->paymentAdd(array());
            $arrayOrder = array('payment_id' => $payment_id);
        }
        if (!$payment_id) {
            return false;
        }
        $post['payment_id'] = $payment_id;
        $post['room_name'] = $roomName;
        $post['price'] = empty($recommend_price) ? $roomPrice : $recommend_price;

        $arrivalDate = @$post['arrival_date'];
        $departureDate = @$post['departure_date'];
        try {
            if (!preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/", $arrivalDate))
            {
                $dateCheckIn = DateTime::createFromFormat('d/m/Y', $arrivalDate);
                $dateCheckOut = DateTime::createFromFormat('d/m/Y', $departureDate);
                $arrivalDate = $dateCheckIn->format('Y-m-d');
                $departureDate = $dateCheckOut->format('Y-m-d');
            }
        } catch (Exception $e) {

        }
        $post['arrival_date'] = $arrivalDate;
        $post['departure_date'] = $departureDate;
        $result = $this->bookingAdd($post);
        if (!$result)
            return false;
        $_SESSION['array_reservation_order'] = $arrayOrder;
        return $result;
    }

    function deleteBookingRoom($booking_id)
    {
        $result = $this->wpdb->update(
            $this->tableBooking,
            array(
                'update_time' => date_i18n('Y-m-d H:i:s'),
                'publish' => 0
            ),
            array('id' => $booking_id),
            array('%s', '%d'),
            array('%d')

        );
        if (!$result)
            return false;
        return true;
    }

    function deletePayment($payment_id)
    {
        $result = $this->wpdb->update(
            $this->tablePayment,
            array(
                'update_time' => date_i18n('Y-m-d H:i:s'),
                'publish' => 0
            ),
            array('id' => $payment_id),
            array('%s', '%d'),
            array('%d')

        );
        if (!$result)
            return false;
        return true;
    }

    function approveBookingRoom($post)
    {
        extract($post);
        if (!$payment_id && is_user_logged_in())
            return false;
        $current_user = wp_get_current_user();
        $objDataPayment = $this->bookingList($payment_id);
        $oldSetPaid = $objDataPayment[0]->set_paid_by;
        $currentUserName = "paid=$set_paid:" . $current_user->user_login;
        $result = $this->wpdb->update(
            $this->tablePayment,
            array(
                'update_time' => date_i18n('Y-m-d H:i:s'),
                'paid_time' => date_i18n('Y-m-d H:i:s'),
                'set_paid_by' => $oldSetPaid ? $oldSetPaid . "," . $currentUserName : $currentUserName,
                'paid' => $set_paid
            ),
            array('id' => $payment_id),
            array('%s', '%s', '%s', '%d'),
            array('%d')

        );
        if (!$result)
            return false;
        return true;
    }

    function deleteSessionOrder($order_id)
    {
        $arrayOrder = @$_SESSION['array_reservation_order'];
        $newArrayOrder = array();
        foreach ($arrayOrder as $key => $value) {
            if ($key != $order_id) {
                $newArrayOrder[] = $value;
            }
        }
        $_SESSION['array_reservation_order'] = $newArrayOrder;
        return true;
    }

    function sendEmail($post, $message, $subject, $headersSendEmail)
    {
        $attachments = "";
        $sendTo = $post['email'];
        return wp_mail($sendTo, $subject, $message, $headersSendEmail, $attachments);
//        return true;
    }
}