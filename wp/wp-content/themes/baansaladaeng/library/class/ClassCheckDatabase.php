<?php
require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
class CheckDatabase
{
    private $wpdb;
    public function __construct($wpdb)
    {
        $this->wpdb = $wpdb;
    }

    public function createBookingTable()
    {
        $sql = "
            DROP TABLE IF EXISTS ics_booking;
            CREATE TABLE `ics_booking` (
              `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
              `room_id` int(10) unsigned DEFAULT NULL,
              `booking_date` date DEFAULT NULL,
              `checkin_time` datetime DEFAULT NULL,
              `checkout_time` datetime DEFAULT NULL,
              `name` varchar(120) DEFAULT NULL,
              `middle_name` varchar(120) DEFAULT NULL,
              `last_name` varchar(120) DEFAULT NULL,
              `date_of_birth` date DEFAULT NULL,
              `passport_no` varchar(120) DEFAULT NULL,
              `nationality` varchar(120) DEFAULT NULL,
              `email` varchar(50) DEFAULT NULL,
              `estimated_arrival_time` date DEFAULT NULL,
              `tel` varchar(50) DEFAULT NULL,
              `no_of_person` int(4) DEFAULT NULL,
              `need_airport_pickup` tinyint(4) DEFAULT NULL,
              `note` text,
              `create_time` datetime DEFAULT NULL,
              `update_time` datetime DEFAULT NULL,
              `publish` tinyint(4) DEFAULT '0',
              PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8
        ";
        dbDelta($sql);
    }

    public function createPaymentTable()
    {
        $sql = "
            DROP TABLE IF EXISTS ics_payment;
            CREATE TABLE `ics_payment` (
              `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
              `booking_id` int(10) unsigned DEFAULT NULL,
              `card_type` varchar(120) DEFAULT NULL,
              `card_holder_name` varchar(120) DEFAULT NULL,
              `card_number` varchar(120) DEFAULT NULL,
              `tree_digit_id` varchar(50) DEFAULT NULL,
              `card_expiry_date` varchar(50) DEFAULT NULL,
              `create_time` datetime DEFAULT NULL,
              `update_time` datetime DEFAULT NULL,
              `publish` tinyint(4) DEFAULT '0',
              PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8
        ";
        dbDelta($sql);
    }

    public function createContactTable()
    {
        $sql = "
            DROP TABLE IF EXISTS ics_contact;
            CREATE TABLE `ics_contact` (
            `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
              `massage` text,
              `tel` varchar(120) DEFAULT NULL,
              `email` varchar(120) DEFAULT NULL,
              `facebook` varchar(120) DEFAULT NULL,
              `twitter` varchar(120) DEFAULT NULL,
              `line` varchar(120) DEFAULT NULL,
              `qr_code_line` text,
              `pinterest` text,
              `tripadvisor` text,
              `latitude` varchar(50) DEFAULT NULL,
              `longitude` varchar(50) DEFAULT NULL,
              PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8
        ";
        dbDelta($sql);
    }

    public function createImageGalleryTable()
    {
        $sql = "
            DROP TABLE IF EXISTS ics_contact;
            CREATE TABLE `ics_image_gallery` (
              `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
              `title` varchar(255) DEFAULT NULL,
              `description` text,
              `link` text,
              `sort` int(11) DEFAULT NULL,
              `image_path` text,
              `create_datetime` datetime DEFAULT NULL,
              `update_datetime` datetime DEFAULT NULL,
              `publish` int(1) DEFAULT '0',
              PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8
        ";
        dbDelta($sql);
    }

}