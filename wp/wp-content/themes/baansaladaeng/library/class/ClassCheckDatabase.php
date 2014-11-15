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
              `payment_id` int(10) DEFAULT NULL,
              `check_in_date` date DEFAULT NULL,
              `check_out_date` date DEFAULT NULL,
              `adults` int(5) DEFAULT '1',
              `need_airport_pickup` tinyint(2) DEFAULT '0',
              `price` decimal(10,2) DEFAULT '0.00',
              `total` decimal(10,2) DEFAULT '0.00',
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
              `order_id` text,
              `card_type` varchar(120) DEFAULT NULL,
              `card_holder_name` varchar(120) DEFAULT NULL,
              `card_number` varchar(120) DEFAULT NULL,
              `tree_digit_id` varchar(50) DEFAULT NULL,
              `card_expiry_date` varchar(50) DEFAULT NULL,
              `name` varchar(120) DEFAULT NULL,
              `middle_name` varchar(120) DEFAULT NULL,
              `last_name` varchar(120) DEFAULT NULL,
              `date_of_birth` varchar(50) DEFAULT NULL,
              `passport_no` varchar(120) DEFAULT NULL,
              `nationality` varchar(120) DEFAULT NULL,
              `email` varchar(50) DEFAULT NULL,
              `estimated_arrival_time` varchar(50) DEFAULT NULL,
              `tel` varchar(50) DEFAULT NULL,
              `no_of_person` int(11) DEFAULT NULL,
              `note` text,
              `timeout` int(4) DEFAULT '6',
              `paid` tinyint(2) DEFAULT '0',
              `paid_time` datetime DEFAULT NULL,
              `set_paid_by` text,
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
              `title_facebook` varchar(120) DEFAULT NULL,
              `link_facebook` text,
              `title_twitter` varchar(120) DEFAULT NULL,
              `link_twitter` text,
              `title_line` varchar(120) DEFAULT NULL,
              `link_line` text,
              `qr_code_line` text,
              `title_pinterest` varchar(120) DEFAULT NULL,
              `link_pinterest` text,
              `title_tripadvisor` varchar(120) DEFAULT NULL,
              `link_tripadvisor` text,
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
            DROP TABLE IF EXISTS ics_image_gallery;
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

    public function createBannerSlideTable()
    {
        $sql = "
            DROP TABLE IF EXISTS ics_banner_slide;
            CREATE TABLE `ics_banner_slide` (
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