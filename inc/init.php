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

        # Prepare: statement to get work-order's inventory ID and type ID
        if ($stmt = $mysqli->prepare("SELECT cusID, invID, typID, Details FROM orders WHERE ordID = ? LIMIT 1")) {

            $stmt->bind_param('i', $_POST['work-order-id']);
            $stmt->execute();
            $stmt->store_result();

            $stmt->bind_result($ord_cusID, $ord_invID, $ord_typID, $ord_desc);
            $stmt->fetch();

            $_SESSION['work-order-id'] = $_POST['work-order-id'];
            $_SESSION['order-details'] = $ord_desc;

            # Prepare: statement to get customer's personal data and shipping address; using ord_cusID
            if ($stmt = $mysqli->prepare("SELECT payID, FirstName, LastName, Address, City, State, Zip, Phone, Email FROM customer WHERE cusID = ? LIMIT 1")) {

                $stmt->bind_param('i', $ord_cusID);
                $stmt->execute();
                $stmt->store_result();

                $stmt->bind_result($cus_payID, $first_name, $last_name, $address, $city, $state, $zip, $phone, $email);
                $stmt->fetch();

                # Set: session variables for customer and their shipping address
                $_SESSION['customer_name']  = $first_name . ' ' . $last_name;
                $_SESSION['phone']          = $phone;
                $_SESSION['email']          = $email;
                $_SESSION['ship-address']   = $address;
                $_SESSION['ship-city']      = $city;
                $_SESSION['ship-state']     = $state;
                $_SESSION['ship-zip']       = $zip;

                # Prepare: statement to get customer's billing address; using payID
                if ($stmt = $mysqli->prepare("SELECT typID, Address, City, State, Zip FROM payments WHERE payID = ? LIMIT 1")) {

                    $stmt->bind_param('i', $cus_payID);
                    $stmt->execute();
                    $stmt->store_result();

                    $stmt->bind_result($pmt_typID, $bill_address, $bill_city, $bill_state, $bill_zip);
                    $stmt->fetch();

                    # Set: session variables for customer's billing address
                    $_SESSION['bill-address']  = $bill_address;
                    $_SESSION['bill-city']     = $bill_city;
                    $_SESSION['bill-state']    = $bill_state;
                    $_SESSION['bill-zip']      = $bill_zip;
                    $_SESSION['copy-shipping'] = true;

                    # Prepare: statement to get work-order's (or customer's) payment type; using payID
                    if ($stmt = $mysqli->prepare("SELECT Description FROM type WHERE typID = ? LIMIT 1")) {

                        $stmt->bind_param('i', $pmt_typID);
                        $stmt->execute();
                        $stmt->store_result();

                        $stmt->bind_result($pmt_desc);
                        $stmt->fetch();

                        # Set: session variables for work-order's payment type
                        $_SESSION['payment-type'] = $pmt_desc;
                    }
                }
            }

            # Prepare: statement to get work-order's type; using ord_invID
            if ($stmt = $mysqli->prepare("SELECT typID FROM inventory WHERE invID = ? LIMIT 1")) {

                $stmt->bind_param('i', $ord_invID);
                $stmt->execute();
                $stmt->store_result();

                $stmt->bind_result($inv_typID);
                $stmt->fetch();

                # Prepare: statement to get work-order's inventory type
                if ($stmt = $mysqli->prepare("SELECT Description FROM type WHERE typID = ? LIMIT 1")) {

                    $stmt->bind_param('i', $inv_typID);
                    $stmt->execute();
                    $stmt->store_result();

                    $stmt->bind_result($inv_desc);
                    $stmt->fetch();

                    # Set: session variables the work-order's media-type
                    $_SESSION['media-type'] = $inv_desc;
                }
            }

            # Prepare: statement to get work-order's type; using ord_typID
            if ($stmt = $mysqli->prepare("SELECT Description FROM type WHERE typID = ? LIMIT 1")) {

                $stmt->bind_param('i', $ord_typID);
                $stmt->execute();
                $stmt->store_result();

                $stmt->bind_result($ord_desc);
                $stmt->fetch();

                $_SESSION['proc'] = $_POST['proc'];     # [TEMP]

                # Set: session variables the work-order's job-type
                $_SESSION['job-type'] = $ord_desc;

                # Set: 'init_result' session variables
                $_SESSION['init_result'] = ($stmt->errno) ? "[error]: failed to locate work-order! ($stmt->error)" : "Successfully located work-order!";
            }
        }

    break;

    case 'update_work-order':                           # Work-Order: UPDATE

        # code...

        # Set: 'init_result' session variables
        $_SESSION['init_result'] = 'Function is not accessible; please try an alternative function!';

    break;

    case 'create_work-order':                           # Work-Order: INSERT

        # Prepare: statement to INSERT customer data into the 'customer' table
        if ($stmt = $mysqli->prepare("INSERT INTO customer (FirstName, LastName, Address, City, State, Zip, Phone, Email, ActiveIND) VALUES (?,?,?,?,?,?,?,?,1)")) {

            $stmt->bind_param('ssssssss', $name[0], $name[1], $_POST['ship-address'], $_POST['ship-city'], $_POST['ship-state'], $_POST['ship-zip'], $_POST['customer-phone'], $_POST['customer-email']);
            $stmt->execute();

            # Set: session variables for customer and their shipping address
            $_SESSION['customer_name']  = $name[0] . ' ' . $name[1];
            $_SESSION['phone']          = $_POST['phone'];
            $_SESSION['email']          = $_POST['email'];
            $_SESSION['ship-address']   = $_POST['ship-address'];
            $_SESSION['ship-city']      = $_POST['ship-city'];
            $_SESSION['ship-state']     = $_POST['ship-state'];
            $_SESSION['ship-zip']       = $_POST['ship-zip'];
        }

        # Select: the last customer ID submitted within the customer's table
        if ($stmt = $mysqli->prepare("SELECT cusID FROM customer ORDER BY cusID DESC LIMIT 1")) {

            $stmt->execute();
            $stmt->store_result();

            $stmt->bind_result($cusID);
            $stmt->fetch();

            # Prepare: statement to INSERT order data into the 'orders' table
            if ($stmt = $mysqli->prepare("INSERT INTO orders (cusID, typeID, Details, Complete) VALUES (?,?,?,1)")) {

                $job_type = (intval($_POST['type']) == 11) ? 'Print Job' : 'Engrave Job';

                $stmt->bind_param('iss', $cusID, $job_type, $_POST['order-details']);
                $stmt->execute();

                # Set: session variables for work-order data
                $_SESSION['job-type']      = $job_type;
                $_SESSION['order-details'] = $_POST['order-details'];

                # Set: 'init_result' session variables
                $_SESSION['init_result'] = ($stmt->errno) ? "[error]: failed to create work-order! ($stmt->error)" : "Successfully created work-order!";
            }
        }

    break;

    case 'search_qa':                                   # Q&A: SEARCH

        # code...

        # Set: 'init_result' session variables
        $_SESSION['init_result'] = 'Function is not accessible; please try an alternative function!';

    break;

    case 'update_qa':                                   # Q&A: UPDATE

        # code...

        # Set: 'init_result' session variables
        $_SESSION['init_result'] = 'Function is not accessible; please try an alternative function!';

    break;

    case 'insert_qa':                                   # Q&A: INSERT

        # code...

        # Set: 'init_result' session variables
        $_SESSION['init_result'] = 'Function is not accessible; please try an alternative function!';

    break;

    case 'search_notify':                               # Search: SEARCH

        # code...

        # Set: 'init_result' session variables
        $_SESSION['init_result'] = 'Function is not accessible; please try an alternative function!';

    break;

    case 'update_notify':                               # Search: UPDATE

        # code...

        # Set: 'init_result' session variables
        $_SESSION['init_result'] = 'Function is not accessible; please try an alternative function!';

    break;

    case 'insert_notify':                               # Search: INSERT

        # code...

        # Set: 'init_result' session variables
        $_SESSION['init_result'] = 'Function is not accessible; please try an alternative function!';

    break;

    default:

        # default

    break;
}

header("Location: http://localhost/", TRUE, 307);

include 'debug/session_debug.php';                      # [TEMP]