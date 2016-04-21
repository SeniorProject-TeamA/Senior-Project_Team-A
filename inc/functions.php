<?php
/**
 * WSC DESCRIPTION!
 *
 * @package     Functions
 * @category    Controllers
 * @author      Justin Don Byrne <justinbyrne001@gmail.com>
 */

namespace WSC\Functions;

use WSC\Functions;

require_once 'psl-config.php';

/**
 * Custom secure method of initiating a PHP session; call at the top of each page that should access PHP
 * session variable(s)
 *
 * @return              NULL                            Initiates a secure PHP session
 */
function sec_session_start() {
    $session_name = 'sec_session_id';                   # Set: custom session name
    $secure       = true;                               # Denies: JavaScript from being able to access the session id
    $httponly     = true;                               # Forces sessions to only use cookies

    if (ini_set('session.use_only_cookies', 1) === FALSE) {
        header("Location: ../error.php?err=Could not initiate a safe session (ini_set)");
        exit();
    }

    $cookieParams = session_get_cookie_params();        # Get: current cookies params
    session_set_cookie_params($cookieParams["lifetime"], $cookieParams["path"], $cookieParams["domain"], $secure, $httponly);

    session_name($session_name);                        # Set: session name to the one set above
    session_start();                                    # Start: PHP session
    session_regenerate_id(true);                        # Regenerate: session; delete the old one
}

/**
 * Verifies the user's identifier and password against the database's credentials via the
 * 'password_verify()' method, which prevents against timing attacks
 *
 * @param               String $id                      [description]
 * @param               String $pass                    [description]
 * @param               Object $mysqli                  [description]
 * @return              Boolean                         [description]
 */
function login($id, $pass, $mysqli) {
    # Using prepared statements means that SQL injection is not possible.
    if ($stmt = $mysqli->prepare("SELECT id, password FROM credentials WHERE empID = ? LIMIT 1")) {
        $stmt->bind_param('s', $id);                    # Bind: '$email' to parameter
        $stmt->execute();                               # Execute: the prepared query
        $stmt->store_result();

        $stmt->bind_result($emp_id, $password);         # Get: variables from result.
        $stmt->fetch();

        # Verify: whether user exists and check whether the account is locked from too many login attempts
        if ($stmt->num_rows == 1) {

            if (checkbrute($emp_id, $mysqli) == true) {
                return false;                           # Account is locked; Send an email to user saying their account is locked
            } else {

                # Check if the password in the database matches the password the user submitted.
                if (password_verify($password, $db_password)) {
                    # Password correct!

                    $user_browser = $_SERVER['HTTP_USER_AGENT'];        # Get: the user-agent string of the user.

                    $_SESSION['emp_id']       = $emp_id;
                    $_SESSION['login_string'] = hash('sha512', $password . $user_browser);

                    return true;                        # Login successful
                } else {
                    # Password not correct!

                    $now = time();                      # Record: this attempt in the database
                    $mysqli->query("INSERT INTO login_attempts(id, time) VALUES ('$emp_id', '$now')");

                    return false;                       # Login unsuccessful
                }
            }
        } else {
            return false;                               # No user exists.
        }
    }
}

/**
 * Sends an email to the user with a reset link if there has been more than 5 failed login attempts
 *
 * @param               String $emp_id                  Employees identifier
 * @param               Object $mysqli                  MySQLi connection object
 * @return              Boolean                         Confirms whether a brute-force attack 'may' have been attempted
 */
function checkbrute($emp_id, $mysqli) {
    $now            = time();                           # Get: time-stamp of current time
    $valid_attempts = $now - (2 * 60 * 60);             # Count: all login attempts within the past 2 hours

    if ($stmt = $mysqli->prepare("SELECT time FROM login_attempts WHERE id = ? AND time > '$valid_attempts'")) {
        $stmt->bind_param('i', $emp_id);

        $stmt->execute();                               # Execute the prepared query
        $stmt->store_result();

        # Check: whether there has been more than 5 failed logins
        if ($stmt->num_rows > 5) {
            return true;
        } else {
            return false;
        }
    }
}