<?php
/**
 * Console processing script(s)
 *
 * @package     Init
 * @category    Console Process Initialization
 * @author      Justin D. Byrne <justin@byrne-systems.com>
 */

require 'psl-config.php';

$mysqli = new mysqli(HOST, USER, PASSWORD, DATABASE);

/* check connection */
if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}

session_start();

if ($stmt = $mysqli->prepare("SELECT cusID FROM orders WHERE ordID = ? LIMIT 1")) {

    $stmt->bind_param('s', $_POST['work-order-id']);
    $stmt->execute();
    $stmt->store_result();

    $stmt->bind_result($cusID);
    $stmt->fetch();

    echo "Good" . '<br>';

    if ($stmt = $mysqli->prepare("SELECT FirstName, LastName, Address, City, State, Zip, Phone, Email FROM customer WHERE cusID = ? LIMIT 1")) {

        $stmt->bind_param('s', $cusID);
        $stmt->execute();
        $stmt->store_result();

        $stmt->bind_result($first_name, $last_name, $address, $city, $state, $zip, $phone, $email);
        $stmt->fetch();

        $_SESSION['customer_name']  = $first_name . ' ' . $last_name;
        $_SESSION['phone']          = $phone;
        $_SESSION['email']          = $email;
        $_SESSION['ship-address']   = $address;
        $_SESSION['ship-city']      = $city;
        $_SESSION['ship-state']     = $state;
        $_SESSION['ship-zip']       = $zip;

        echo "Good 2" . '<br>';

        $stmt->close();

        header("Location: http://localhost/", TRUE, 307);
    }
}

include 'debug/session_debug.php';                      # [TEMP]