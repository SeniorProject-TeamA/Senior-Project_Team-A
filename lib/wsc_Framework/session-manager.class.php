<?php
/**
 * Instantiates and sets new (secure) session(s) for transmitting data to/from the user's
 * UI (or front-end) with an application's business logic (or back-end)
 *
 * @package      Session Manager
 * @category     Control
 * @author       Justin D. Byrne <justinbyrne001@gmail.com>
 */

namespace WSC\Framework\Controls;

use WSC\Framework\Controls\SessionManager;

/**
 * Session Manager
 *
 * Instantiates secure session(s) for transmitting data to/from back and front-end(s)
 */
class SessionManager {
    /**
     * Custom secure method of initiating a PHP session; call at the top of each page that should access PHP
     * session variable(s)
     *
     * @return          NULL                            Initiates a secure PHP session
     */
    public function sec_session_start($session_name = 'sec_session_id')
    {
        $secure   = true;                               # Denies: JavaScript from being able to access the session id
        $httponly = true;                               # Forces sessions to only use cookies

        if (ini_set('session.use_only_cookies', 1) === FALSE) {
            header("Location: ../error.php?err=Could not initiate a safe session (ini_set)");
            exit();
        }

        $cookieParams = session_get_cookie_params();    # Get: current cookies params

        session_set_cookie_params($cookieParams["lifetime"], $cookieParams["path"], $cookieParams["domain"], $secure, $httponly);

        session_name($session_name);                    # Set: session name
        session_start();                                # Start: PHP session
        session_regenerate_id(true);                    # Regenerate: session; delete the old one
    }

    /**
     * [session_timeout description]
     *
     * @param           Integer $inactivity             [description]
     * @return          NULL                            [description]
     */
    public function session_timeout($inactivity = 600)
    {
        if (isset($_SESSION["timeout"])) {
            $sessionTTL = time() - $_SESSION["timeout"];# Calculate: session's time to live

            if ($sessionTTL > $inactivity) {
                session_destroy();
                header("Location: logout.php?err=You have been logged out; session has expired!", TRUE, 307);             # 307: Temporary Redirect
            }
        }

        $_SESSION["timeout"] = time();                  # Initiate: session timeout
    }
}