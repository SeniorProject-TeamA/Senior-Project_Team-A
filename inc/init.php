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

    case 'search_customer':                             # Customer: SEARCH

        $name = explode(' ', $_POST['customer-name']);

        if ($stmt = $mysqli->prepare("SELECT payID, FirstName, LastName, Address, City, State, Zip, Phone, Email FROM customer WHERE LastName = ? LIMIT 1")) {

            $stmt->bind_param('s', $name[1]);           # Find: by last name
            $stmt->execute();
            $stmt->store_result();

            $stmt->bind_result($payID, $first_name, $last_name, $address, $city, $state, $zip, $phone, $email);
            $stmt->fetch();

            if ($stmt = $mysqli->prepare("SELECT Address, City, State, Zip FROM payments WHERE payID = ? LIMIT 1")) {

                $stmt->bind_param('i', $payID);         # Find: by payID (PK)
                $stmt->execute();
                $stmt->store_result();

                $stmt->bind_result($bill_address, $bill_city, $bill_state, $bill_zip);
                $stmt->fetch();

                $stmt->close();                         # Close: database connection

                # Set: session variables for customer's billing address
                $_SESSION['bill-address'] = $bill_address;
                $_SESSION['bill-city']    = $bill_city;
                $_SESSION['bill-state']   = $bill_state;
                $_SESSION['bill-zip']     = $bill_zip;

            }

            $stmt->close();                             # Close: database connection

            # Set: session variables for customer's name, phone, email, and shipping address
            $_SESSION['customer_name'] = $first_name . ' ' . $last_name;
            $_SESSION['phone']         = $phone;
            $_SESSION['email']         = $email;
            $_SESSION['ship-address']  = $address;
            $_SESSION['ship-city']     = $city;
            $_SESSION['ship-state']    = $state;
            $_SESSION['ship-zip']      = $zip;

            # Set: 'init_result' session variables
            $_SESSION['init_result'] = ($stmt->errno) ? "[error]: failed to locate customer! ($stmt->error)" : "Found customer: $name[0] $name[1]!";
        }

    break;

    case 'update_customer':                             # Customer: UPDATE

        $ui_name = explode(" ", $_POST['customer-name']);

        # Prepare: statement to SELECT customer data into the 'customer' table
        if ($stmt = $mysqli->prepare("SELECT cusID, FirstName, LastName, Address, City, State, Zip, Phone, Email FROM customer WHERE LastName = ? LIMIT 1")) {

            $stmt->bind_param('s', $ui_name[1]);        # Search: by last name
            $stmt->execute();
            $stmt->store_result();

            $stmt->bind_result($cusID, $col_first_name, $col_last_name, $col_address, $col_city, $col_state, $col_zip, $col_phone, $col_email);
            $stmt->fetch();

            # Compare: UI data with DB data to identify variance(s)
            $ui_name[0] = ($col_first_name != $ui_name[0])                                                   ? $ui_name[0]              : $col_first_name;             # First name
            $ui_name[1] = ($col_last_name  != $ui_name[1])                                                   ? $ui_name[1]              : $col_last_name;              # Last name
            $ui_address = ($col_address    != (isset($_POST['ship-address']))   ?: $_POST['ship-address'])   ? $_POST['ship-address']   : $col_address;                # Address
            $ui_city    = ($col_city       != (isset($_POST['ship-city']))      ?: $_POST['ship-city'])      ? $_POST['ship-city']      : $col_city;                   # City
            $ui_state   = ($col_state      != (isset($_POST['ship-state']))     ?: $_POST['ship-state'])     ? $_POST['ship-state']     : $col_state;                  # State
            $ui_zip     = ($col_zip        != (isset($_POST['ship-zip']))       ?: $_POST['ship-zip'])       ? $_POST['ship-zip']       : $col_zip;                    # Zip
            $ui_phone   = ($col_phone      != (isset($_POST['customer-phone'])) ?: $_POST['customer-phone']) ? $_POST['customer-phone'] : $col_phone;                  # Phone
            $ui_email   = ($col_email      != (isset($_POST['customer-email'])) ?: $_POST['customer-email']) ? $_POST['customer-email'] : $col_email;                  # Email

            # Prepare: statement to UPDATE customer data into the 'customer' table
            if ($stmt = $mysqli->prepare("UPDATE customer SET FirstName = ?, LastName = ?, Address = ?, City = ?, State = ?, Zip = ?, Phone = ?, Email = ? WHERE cusID = ?")) {

                $stmt->bind_param('ssssssssi', $ui_name[0], $ui_name[1], $ui_address, $ui_city, $ui_state, $ui_zip, $ui_phone, $ui_email, $cusID);
                $stmt->execute();

                $stmt->close();                         # Close: database connection

                # Set: session variables for customer and their shipping address
                $_SESSION['customer_name'] = $ui_name[0] . ' ' . $ui_name[1];
                $_SESSION['ship-address']  = $ui_address;
                $_SESSION['ship-city']     = $ui_city;
                $_SESSION['ship-state']    = $ui_state;
                $_SESSION['ship-zip']      = $ui_zip;
                $_SESSION['phone']         = $ui_phone;
                $_SESSION['email']         = $ui_email;

                # Set: 'init_result' session variables
                $_SESSION['init_result'] = ($stmt->errno) ? "[error]: failed to update customer! ($stmt->error)" : "Successfully updated customer: " . $name[0] . ' ' . $name[1];
            }
        }

    break;

    case 'create_customer':                             # Customer: CREATE

        $name = explode(" ", $_POST['customer-name']);

        # Prepare: statement to INSERT customer data into the 'customer' table
        if ($stmt = $mysqli->prepare("INSERT INTO customer (FirstName, LastName, Address, City, State, Zip, Phone, Email, ActiveIND) VALUES (?,?,?,?,?,?,?,?,1)")) {

            $stmt->bind_param('ssssssss', $name[0], $name[1], $_POST['ship-address'], $_POST['ship-city'], $_POST['ship-state'], $_POST['ship-zip'], $_POST['customer-phone'], $_POST['customer-email']);
            $stmt->execute();

            $stmt->close();                             # Close: database connection

            # Set: session variables for customer and their shipping address
            $_SESSION['customer_name']  = $name[0] . ' ' . $name[1];
            $_SESSION['phone']          = $_POST['phone'];
            $_SESSION['email']          = $_POST['email'];
            $_SESSION['ship-address']   = $_POST['ship-address'];
            $_SESSION['ship-city']      = $_POST['ship-city'];
            $_SESSION['ship-state']     = $_POST['ship-state'];
            $_SESSION['ship-zip']       = $_POST['ship-zip'];

            # Set: 'init_result' session variables
            $_SESSION['init_result'] = ($stmt->errno) ? "[error]: failed to create customer! ($stmt->error)" : "Successfully created customer: " . $name[0] . ' ' . $name[1];
        }

    break;

    case 'search_work-order':                           # Work-Order: SEARCH

        if ($stmt = $mysqli->prepare("SELECT cusID FROM orders WHERE ordID = ? LIMIT 1")) {

            $stmt->bind_param('i', $_POST['work-order-id']);
            $stmt->execute();
            $stmt->store_result();

            $stmt->bind_result($cusID);
            $stmt->fetch();

            if ($stmt = $mysqli->prepare("SELECT payID, FirstName, LastName, Address, City, State, Zip, Phone, Email FROM customer WHERE cusID = ? LIMIT 1")) {

                $stmt->bind_param('i', $cusID);
                $stmt->execute();
                $stmt->store_result();

                $stmt->bind_result($payID, $first_name, $last_name, $address, $city, $state, $zip, $phone, $email);
                $stmt->fetch();

                $_SESSION['customer_name']  = $first_name . ' ' . $last_name;
                $_SESSION['phone']          = $phone;
                $_SESSION['email']          = $email;
                $_SESSION['ship-address']   = $address;
                $_SESSION['ship-city']      = $city;
                $_SESSION['ship-state']     = $state;
                $_SESSION['ship-zip']       = $zip;

                if ($stmt = $mysqli->prepare("SELECT Address, City, State, Zip FROM payments WHERE payID = ? LIMIT 1")) {

                    $stmt->bind_param('i', $payID);
                    $stmt->execute();
                    $stmt->store_result();

                    $stmt->bind_result($bill_address, $bill_city, $bill_state, $bill_zip);
                    $stmt->fetch();

                    $_SESSION['bill-address'] = $bill_address;
                    $_SESSION['bill-city']    = $bill_city;
                    $_SESSION['bill-state']   = $bill_state;
                    $_SESSION['bill-zip']     = $bill_zip;

                    $_SESSION['copy-shipping'] = true;

                    $stmt->close();
                }
            }
        }

    break;

    case 'update_work-order':                           # Work-Order: UPDATE

        # code...

    break;

    case 'insert_work-order':                           # Work-Order: INSERT

        $ordID = (isset($_POST['work-order-id'])) ? $_POST['work-order-id'] : null;

        // # Prepare: statement to INSERT customer data into the 'customer' table
        // if ($stmt = $mysqli->prepare("INSERT INTO orders (FirstName, LastName, Address, City, State, Zip, Phone, Email, ActiveIND) VALUES (?,?,?,?,?,?,?,?,1)")) {

        //     $stmt->bind_param('ssssssss', $name[0], $name[1], $_POST['ship-street'], $_POST['ship-city'], $_POST['ship-state'], $_POST['ship-zip'], $_POST['customer-phone'], $_POST['customer-email']);
        //     $stmt->execute();

        //     $stmt->close();                             # Close: database connection

        //     $_SESSION['proc'] = $_POST['proc'];         # [TEMP]

        //     # Set: 'init_result' session variables
        //     $_SESSION['init_result'] = ($stmt->errno) ? "[error]: failed to create customer! ($stmt->error)" : "Successfully created customer: $name[0] $name[1]";
        // }

    break;

    case 'search_qa':                                   # Q&A: SEARCH

        # code...

    break;

    case 'update_qa':                                   # Q&A: UPDATE

        # code...

    break;

    case 'insert_qa':                                   # Q&A: INSERT

        # code...

    break;

    case 'search_notify':                               # Search: SEARCH

        # code...

    break;

    case 'update_notify':                               # Search: UPDATE

        # code...

    break;

    case 'insert_notify':                               # Search: INSERT

        # code...

    break;

    default:

        # default

    break;
}

header("Location: http://localhost/", TRUE, 307);

include 'debug/session_debug.php';                      # [TEMP]