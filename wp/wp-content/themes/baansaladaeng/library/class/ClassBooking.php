<?php

class Booking
{
    private $wpdb;
    private $tableBooking = "ics_booking";
    private $tablePayment = "ics_payment";
    private $tablePost = "wp_booking_hotel_posts";

    public function __construct($wpdb)
    {
        $this->wpdb = $wpdb;
    }

    public function bookingList($id = 0)
    {
        $strAnd = $id ? " AND a.id = $id": "";
        $sql = "
            SELECT
              a.*,
              b.`id` AS payment_id,
              b.*,
              c.post_title AS room_name
            FROM
              `$this->tableBooking` a
              INNER JOIN `$this->tablePayment` b
                ON (
                  a.`id` = b.`booking_id`
                  AND b.`publish` = 1
                )
              INNER JOIN `$this->tablePost` c
                ON (
                  a.room_id = c.ID
                )
            WHERE 1
              AND b.`publish` = 1
              $strAnd
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

    public function bookingAdd($data)
    {
        extract($data);
        $booking_date = date("Y-m-d", strtotime(@$booking_date));
        $need_airport_pickup = @$need_airport_pickup == "on" ? 1 : 0;
        $result = $this->wpdb->insert(
            $this->tableBooking,
            array(
                'room_id' => $room_id,
                'booking_date' => @$booking_date,
                'checkin_time' => "0000-00-00 00:00:00",
                'checkout_time' => "0000-00-00 00:00:00",
                'name' => @$customer_name,
                'middle_name' => @$middle_name,
                'last_name' => @$last_name,
                'date_of_birth' => @$date_of_birth,
                'passport_no' => @$passport_no,
                'nationality' => @$nationality,
                'email' => @$customer_email,
                'estimated_arrival_time' => @$estimated_arrival_time,
                'tel' => @$tel,
                'no_of_person' => @$no_of_person,
                'need_airport_pickup' => $need_airport_pickup,
                'note' => @$note,
                'create_time' => date('Y-m-d H:i:s'),
                'update_time' => '0000-00-00 00:00:00',
                'publish' => 1
            ),
            array(
                '%d',
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
                '%s',
                '%s',
                '%s',
                '%d'
            )
        );
        if ($result) {
            return $this->wpdb->insert_id;
        }
        return false;
    }

    public function paymentAdd($data)
    {
        extract($data);
        $card_expiry_date = "$card_expiry_date1/$card_expiry_date2";
        $result = $this->wpdb->insert(
            $this->tablePayment,
            array(
                'booking_id' => @$booking_id,
                'card_type' => @$card_type,
                'card_holder_name' => @$card_holder_name,
                'card_number' => @$card_number,
                'tree_digit_id' => @$tree_digit_id,
                'card_expiry_date' => $card_expiry_date,
                'create_time' => date('Y-m-d H:i:s'),
                'update_time' => '0000-00-00 00:00:00',
                'publish' => 1
            ),
            array(
                '%d',
                '%s',
                '%s',
                '%s',
                '%s',
                '%s',
                '%s',
                '%s',
                '%d'
            )
        );
        if ($result) {
            return $this->wpdb->insert_id;
        }
        return false;
    }
}