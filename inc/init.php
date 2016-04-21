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

# Check: database connection connection
if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}

session_start();                                        # Start: session to carry session data

# Master: switch construct operating according the passed '$proc' (or Procedure) variable; via <form> POST
switch ($_POST['proc']) {
    case 'get_customer_data':

        if ($stmt = $mysqli->prepare("SELECT cusID FROM orders WHERE ordID = ? LIMIT 1")) {

            $stmt->bind_param('s', $_POST['work-order-id']);
            $stmt->execute();
            $stmt->store_result();

            $stmt->bind_result($cusID);
            $stmt->fetch();

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
                $_SESSION['proc']           = $_POST['proc'];

                $stmt->close();
            }
        }

        break;

    default:
        # default
        break;
}

header("Location: http://localhost/", TRUE, 307);

include 'debug/session_debug.php';                      # [TEMP]