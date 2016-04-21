<?php
/**
 * Endorses that specific content, input, or data is appropriately organized and/or formatted prior
 * to advancing intermediate subroutines.
 *
 * @package     Validation\Error
 * @category    Agent
 * @author      Justin D. Byrne <justin@byrne-systems.com>
 */

namespace WSC\Framework\Handlers;

use WSC\Framework\Handlers\Validation;
use WSC\Framework\Handlers\Error;

require_once 'error.class.php';

/**
 * Validation Agent
 *
 * Confirms that transmitted data meets specific criterion prior to allowing a transitional method
 * to progress.
 */
class Validation extends Error {
    /**
     * Sends an email to the user with a reset link if there has been more than 5 failed login attempts
     *
     * @param               String $emp_id                  Employees identifier
     * @param               Object $mysqli                  MySQLi connection object
     * @return              Boolean                         Confirms whether a brute-force attack 'may' have been attempted
     */
    public function checkbrute($id, $mysqli)
    {
        $now            = time();                           # Get: time-stamp of current time
        $valid_attempts = $now - (2 * 60 * 60);             # Count: all login attempts within the past 2 hours

        if ($stmt = $mysqli->prepare("SELECT time FROM login_attempts WHERE id = ? AND time > '$valid_attempts'")) {
            $stmt->bind_param('i', $id);

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

    /**
     * Verifies file's presence (or existence) via the passed '$file' in this method's param
     *
     * @param           String $file                    File to verify
     * @return          Boolean                         Confirms whether file exists
     */
    public function check_file($file)
    {
        $result = NULL;

        $ext = ltrim(pathinfo($file, PATHINFO_EXTENSION), '.');         # Isolate: packages file extension
        $nfo = pathinfo($file);                                         # Get: info regarding package's file directory, base-name, extension, and name

        $result = ($nfo['extension'] === $ext) ? true : false;

        return $result;
    }

    /**
     * Validates whether the email passed is a properly formatted email address
     * (i.e., email@server.net)
     *
     * @param           String $email                   E-mail address to validate
     * @return          Boolean                         Result of validation test
     */
    public function email_format($email)
    {
        $r = false;

        if (is_array($email)) {
            foreach ($email as $address) {
                $r = (!filter_var($address, FILTER_VALIDATE_EMAIL) === false) ? true : false;
            }
        } else {
            $r = (!filter_var($email, FILTER_VALIDATE_EMAIL) === false) ? true : false;
        }

        return $r;
    }

    public function validate_hash($hash1, $hash2)
    {
        return ($hash1 === $hash2) ? true : false;
    }

    /**
     * Verifies the user's identifier and password against the database's credentials via the
     * 'password_verify()' method, which is designed to prevent against timing attacks
     *
     * @param           String $id                      [description]
     * @param           String $pass                    [description]
     * @param           Object $mysqli                  [description]
     * @return          Boolean                         [description]
     */
    public function login($id, $hash, $mysqli)
    {
        if ($stmt = $mysqli->prepare("SELECT empID, Password FROM credentials WHERE empID = ? LIMIT 1")) {
            $stmt->bind_param('s', $id);                # Bind: '$id' to parameter
            $stmt->execute();                           # Execute: the prepared query
            $stmt->store_result();

            $stmt->bind_result($col1, $col2);           # Get: variables from result.
            $stmt->fetch();

            # Check if the password in the database matches the password the user submitted.
            if ($this->validate_hash(hash('sha512', $col2), $hash)) {
                # Password correct!

                $stmt = $mysqli->prepare("SELECT Title, FirstName, LastName FROM employee WHERE empID = ? LIMIT 1");
                $stmt->bind_param('s', $col1);          # Bind: '$id' to parameter
                $stmt->execute();                       # Execute: the prepared query
                $stmt->store_result();

                $stmt->bind_result($title, $first_name, $last_name);
                $stmt->fetch();

                $user_browser = $_SERVER['HTTP_USER_AGENT'];            # Get: the user-agent string of the user.

                session_start();
                $_SESSION['emp_id']       = $col1;
                $_SESSION['emp_title']    = $title;
                $_SESSION['emp_name']     = $first_name . ' ' . $last_name;
                $_SESSION['login_string'] = hash('sha512', $col2 . $user_browser);

                $stmt->close();

                return true;
            } else {
                # Password not correct!

                // include_once('debug/login-debug.php');  # [TEMP]
                $now = time();                          # Record: this attempt in the database
                $mysqli->query("INSERT INTO credentials(empID, Time) VALUES ('$id', '$now')");

                $stmt->close();

                return false;
            }
        }
    }
}
?>