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

        # Prepare: SQL query to get a customers' ID (cusID)
        if ($stmt = $mysqli->prepare("SELECT cusID FROM orders WHERE ordID = ? LIMIT 1")) {

            $stmt->bind_param('s', $_POST['work-order-id']);
            $stmt->execute();
            $stmt->store_result();

            $stmt->bind_result($cusID);
            $stmt->fetch();

            # Prepare: SQL query to get specific data from the 'customer' table using the (aforementioned) customers' ID (cusID)
            if ($stmt = $mysqli->prepare("SELECT FirstName, LastName, Address, City, State, Zip, Phone, Email FROM customer WHERE cusID = ? LIMIT 1")) {

                $stmt->bind_param('s', $cusID);
                $stmt->execute();
                $stmt->store_result();

                $stmt->bind_result($first_name, $last_name, $address, $city, $state, $zip, $phone, $email);
                $stmt->fetch();

                # Set: session variables
                $_SESSION['customer_name']  = $first_name . ' ' . $last_name;
                $_SESSION['phone']          = $phone;
                $_SESSION['email']          = $email;
                $_SESSION['ship-address']   = $address;
                $_SESSION['ship-city']      = $city;
                $_SESSION['ship-state']     = $state;
                $_SESSION['ship-zip']       = $zip;
                $_SESSION['proc']           = $_POST['proc'];

                $stmt->close();                         # Close: database connection
            }

            $stmt->close();                             # Close: database connection
        }

        break;

    case 'create_customer':                             # Customer: CREATE

        $name = explode(" ", $_POST['customer-name']);

        if ($stmt = $mysqli->prepare("INSERT INTO customer (FirstName, LastName, Address, City, State, Zip, Phone, Email, ActiveIND) VALUES (?,?,?,?,?,?,?,?,1)")) {

            $stmt->bind_param('ssssssss', $name[0], $name[1], $_POST['ship-street'], $_POST['ship-city'], $_POST['ship-state'], $_POST['ship-zip'], $_POST['customer-phone'], $_POST['customer-email']);
            $stmt->execute();

            $stmt->close();                             # Close: database connection

            # Set: 'init_result' session variables
            ($stmt->errno) ? $_SESSION['init_result'] = "[error]: failed to create customer! . $stmt->error" : $_SESSION['init_result'] = "Successfully created customer: $name[0] $name[1]";
        }

        break;

    case 'update_customer':                             # Customer: UPDATE

        $name = explode(" ", $_POST['customer-name']);

        $address = (isset($_POST['ship-street'])) ?: $_POST['ship-street'];
        $city    = (isset($_POST['ship-city']))   ?: $_POST['ship-city'];
        $state   = (isset($_POST['ship-state']))  ?: $_POST['ship-state'];
        $zip     = (isset($_POST['ship-zip']))    ?: $_POST['ship-zip'];
        $phone   = (isset($_POST['ship-phone']))  ?: $_POST['ship-phone'];
        $email   = (isset($_POST['ship-email']))  ?: $_POST['ship-email'];

        if ($stmt = $mysqli->prepare("SELECT cusID, FirstName, LastName, Address, City, State, Zip, Phone, Email FROM customer WHERE LastName = ? LIMIT 1")) {

            $stmt->bind_param('s', $name[1]);
            $stmt->execute();
            $stmt->store_result();

            $stmt->bind_result($cus_ID, $first_name, $last_name, $address, $city, $state, $zip, $phone, $email);
            $stmt->fetch();

            if ($stmt = $mysqli->prepare("UPDATE customer SET Address = ?, City = ?, State = ?, Zip = ?, Phone = ?, Email = ? WHERE cusID = ?")) {

                $stmt->bind_param('ssssssi', $address, $city, $state, $zip, $phone, $email, $cus_ID);
                $stmt->execute();

                $stmt->close();                         # Close: database connection

                # Set: 'init_result' session variables
                ($stmt->errno) ? $_SESSION['init_result'] = "[error]: failed to update customer! . $stmt->error" : $_SESSION['init_result'] = "Successfully updated customer: $name[0] $name[1] !";
            }

            $stmt->close();                             # Close: database connection
        }

        break;

    case 'search_customer':                             # Customer: SEARCH

        $name = explode(" ", $_POST['customer-name']);

        if ($stmt = $mysqli->prepare("SELECT FirstName, LastName, Address, City, State, Zip, Phone, Email FROM customer WHERE LastName = ? LIMIT 1")) {

            $stmt->bind_param('s', $name[1]);
            $stmt->execute();
            $stmt->store_result();

            $stmt->bind_result($first_name, $last_name, $address, $city, $state, $zip, $phone, $email);
            $stmt->fetch();

            $stmt->close();                             # Close: database connection

            # Set: session variables
            $_SESSION['customer_name']  = $first_name . ' ' . $last_name;
            $_SESSION['phone']          = $phone;
            $_SESSION['email']          = $email;
            $_SESSION['ship-address']   = $address;
            $_SESSION['ship-city']      = $city;
            $_SESSION['ship-state']     = $state;
            $_SESSION['ship-zip']       = $zip;

            $_SESSION['proc']           = $_POST['proc'];

            # Set: 'init_result' session variables
            ($stmt->errno) ? $_SESSION['init_result'] = "[error]: failed to locate customer! . $stmt->error" : $_SESSION['init_result'] = "Found customer: $name[0] $name[1]!";
        }

        break;

    default:
        # default
        break;
}

header("Location: http://localhost/", TRUE, 307);

include 'debug/session_debug.php';                      # [TEMP]