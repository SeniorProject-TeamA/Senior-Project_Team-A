<?php
/**
 * WSC DESCRIPTION!
 *
 * @package     Session Control
 * @category    Controllers
 * @author      Justin Don Byrne <justinbyrne001@gmail.com>
 */

// session_start();                                     # Initiate: session
sec_session_start();

$inactive = 600;                                        # 10 min

if (isset($_SESSION["timeout"])) {

    $sessionTTL = time() - $_SESSION["timeout"];        # Calculate: session's time to live

    if ($sessionTTL > $inactive) {

        session_destroy();
        header("Location: /logout.php", TRUE, 307);     # 307: Temporary Redirect

    }
}

$_SESSION["timeout"] = time();                          # Initiate: session timeout