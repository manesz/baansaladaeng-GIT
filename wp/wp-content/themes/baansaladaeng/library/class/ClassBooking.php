<?php

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

    public function bookingList($id = 0, $room_id = 0, $is_checkout = false)
    {
        $strAnd = $is_checkout ? "AND a.checkout_time = '0000-00-00 00:00:00'" : "";
        $strAnd .= $id ? "AND a.id = $id" : "";
        $strAnd .= $room_id ? "AND b.room_id = $room_id" : "";
        $sql = "
            SELECT
              a.*,
              b.`id` AS booking_id,
              b.*,
              c.post_title AS room_name
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
              AND b.`publish` = 1
              $strAnd
            ORDER BY b.create_time DESC
        ";

        $myrows = $this->wpdb->get_results($sql);
        return $myrows;
    }

    public function getBookingListByMonth($month, $year)
    {
        $sql = "
            SELECT
              `room_id`,
              `booking_date`
            FROM `$this->tableBooking`
            WHERE 1
            AND MONTH(booking_date) = $month
            AND YEAR(booking_date) = $year
            AND checkout_time = '0000-00-00 00:00:00'
            ORDER BY room_id;
        ";
        $rows = $this->wpdb->get_results($sql);
        return $rows;
    }

    public function getRoomIDByCheckInCheckOut($check_in = "", $check_out = "")
    {
        $sql = "
            SELECT
              `room_id`,
              `booking_date`
            FROM `$this->tableBooking`
            WHERE 1
            AND MONTH(booking_date) = $check_in
            AND YEAR(booking_date) = $check_out
            AND checkout_time = '0000-00-00 00:00:00'
            ORDER BY room_id;
        ";
        $rows = $this->wpdb->get_results($sql);
        return $rows;
    }

    public function getRoomByDateCheckInCheckOut($check_in, $check_out, $room_id = 0)
    {
        $strAnd = $room_id ? " AND room_id=$room_id" : "";
        $sql = "
            SELECT
              *
            FROM
              `$this->tableBooking`
            WHERE (
                `check_in_date`
                AND `check_out_date` BETWEEN '$check_in'
                AND '$check_out'
              )
              $strAnd
        ";
        $rows = $this->wpdb->get_results($sql);
        return $rows;
    }

    public function checkRoom($post)
    {
        extract($post);
        $dateCheckIn = DateTime::createFromFormat('d/m/Y', $check_in);
        $dateCheckOut = DateTime::createFromFormat('d/m/Y', $check_out);
        $checkIn = $dateCheckIn->format('Y-m-d');
        $checkOut = $dateCheckOut->format('Y-m-d');
        $roomId = $room_id;
        $result = $this->getRoomByDateCheckInCheckOut($checkIn, $checkOut, $roomId);
        if (count($result) > 0) {
            return false;
        } else {
            return true;
        }
    }

    public function bookingAdd($data)
    {
//        $booking_date = date("Y-m-d", strtotime(@$booking_date));
//        $need_airport_pickup = @$need_airport_pickup == "on" ? 1 : 0;

        session_start();
        $arrayOrder = @$_SESSION['array_reservation_order'];
        extract($data);
        //check booking มีแล้วหรือยัง
        foreach ($arrayOrder as $value) {
            $roomID = @$value['room_id'];
            $roomName = @$value['room_name'];
            $arrivalDate = @$value['arrival_date'];
            $arrivalDateConvert = DateTime::createFromFormat('d/m/Y', $arrivalDate);
            $departureDate = @$value['departure_date'];
            $departureDateConvert = DateTime::createFromFormat('d/m/Y', $departureDate);
            $result = $this->getRoomByDateCheckInCheckOut($arrivalDateConvert->format('Y-m-d'),
                $departureDateConvert->format('Y-m-d'), $roomID);
            if ($result) {
                return "Sorry, $roomName customer request.";
            }
        }
        foreach ($arrayOrder as $value) {
            $roomID = @$value['room_id'];
            $price = @$value['price'];
            $arrivalDate = @$value['arrival_date'];
            $arrivalDateConvert = DateTime::createFromFormat('d/m/Y', $arrivalDate);
            $departureDate = @$value['departure_date'];
            $departureDateConvert = DateTime::createFromFormat('d/m/Y', $departureDate);
            $timeDiff = abs(strtotime($departureDateConvert->format('Y-m-d')) -
                strtotime($arrivalDateConvert->format('Y-m-d')));
            $numberDays = $timeDiff / 86400;
            $numberDays = ceil($numberDays);
            $total = ($numberDays + 1) * $price; //return "$total $price";
            $result = $this->wpdb->insert(
                $this->tableBooking,
                array(
                    'room_id' => $roomID,
                    'payment_id' => $payment_id,
                    'check_in_date' => $arrivalDateConvert->format('Y-m-d'),
                    'check_out_date' => $departureDateConvert->format('Y-m-d'),
                    'price' => $price,
                    'total' => $total,
                    'create_time' => date('Y-m-d H:i:s'),
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
                    '%s',
                    '%s',
                    '%d'
                )
            );
            if (!$result) {
                return 'fail';
            }
        }
        $_SESSION['array_reservation_order'] = array();
        return true;
    }

    public function paymentAdd($data)
    {
        extract($data);
//        $card_expiry_date = "$card_expiry_date1/$card_expiry_date2";
        $date_of_birth = "$payment_date_of_birth_3-$payment_date_of_birth_2-$payment_date_of_birth_1";
        $estimated_arrival_time = "$payment_est_arrival1:$payment_est_arrival2:$payment_est_arrival3";
        $card_expiry_date = "$card_expiry_date1/$card_expiry_date2";
        $result = $this->wpdb->insert(
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
                'no_of_person' => @$payment_no_of_person,
                'need_airport_pickup' => @$payment_need_airport_pickup,
                'note' => @$payment_note,
                'card_type' => @$card_type,
                'card_holder_name' => @$card_holder_name,
                'card_number' => @$card_number,
                'tree_digit_id' => @$tree_digit_id,
                'card_expiry_date' => @$card_expiry_date,
                'create_time' => date('Y-m-d H:i:s'),
                'update_time' => '0000-00-00 00:00:00',
                'publish' => 1
            ),
            array(
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
                '%s',
                '%s',
                '%s',
                '%s',
                '%s',
                '%s',
                '%s',
                '%s',
                '%d',
            )
        );
        if ($result) {
            return $this->wpdb->insert_id;
        }
        return false;
    }

    function addSessionOrder($post)
    {
        session_start();
        $arrayOrder = @$_SESSION['array_reservation_order'];
        $roomID = @$post['room_id'];
        $query = new WP_Query(array(
            'post_type' => 'room',
            'post__in' => array($roomID)
        ));
        $posts = $query->get_posts();
        $customField = get_post_custom($roomID);

        $roomName = @$posts[0]->post_title;
        $roomPrice = @$customField['price'][0];

        $arrivalDate = $post['arrival_date'];
        $departureDate = $post['departure_date'];
        $timeDiff = abs(strtotime($departureDate) - strtotime($arrivalDate));
        $numberDays = $timeDiff / 86400;
        $total = $numberDays * $roomPrice;

        $arrayOrder[] = array(
            'room_id' => $roomID,
            'room_name' => $roomName,
            'arrival_date' => @$arrivalDate,
            'departure_date' => @$departureDate,
            'adults' => @$post['adults'],
            'price' => $roomPrice,
        );
        $_SESSION['array_reservation_order'] = $arrayOrder;
        return true;
    }

    function deleteSessionOrder($order_id)
    {
        session_start();
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
}