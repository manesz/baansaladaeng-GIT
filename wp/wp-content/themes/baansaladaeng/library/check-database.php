<?php
require_once ("class/ClassCheckDatabase.php");
$objClass = new CheckDatabase($wpdb);

$objClass->createBookingTable();
$objClass->createPaymentTable();
$objClass->createContactTable();
$objClass->createImageGalleryTable();