<?php
/**
 * Error Handler
 *
 * @package     Validation\Error
 * @category    Handler
 * @author      Justin D. Byrne <justin@byrne-systems.com>
 */

namespace WSC\Framework\Handlers;

use WSC\Framework\Handlers\Error;
use WSC\Framework\Agents\Log;

require_once 'log.class.php';

/**
 * Error Handler
 *
 * [Description]
 */
class Error extends Log {
    /**
     * Returns the current date for logging, indexing, or anything else requiring a timestamp
     *
     * @method String get_date()
     *
     * @return          String                          Return the current time; correctly formatted
     */
    private function get_date() {
        date_default_timezone_set('America/Los_Angeles');
        return "[ " . date('l jS \of F Y h:i:s A') . " ] ";
    }

    ////////////////////// Public //////////////////////

    /**
     * Generates a valid error message specific to the Waffle framework, then logs the message in
     * "waffle.error.log" prior to exiting the framework while displaying the error message passed.
     *
     * @method void error(String $time, String $msg, String $func, String $class)
     *
     * @param           String   $msg                   Error message to log and print through std-out
     * @param           Constant $class                 Originating class from where the error propagated
     * @param           Constant $fn                    Originating function from where the error propagated
     * @param           Constant $ln                    Originating line number from where the error propagated
     * @param           Constant $fl                    Originating file from where the error propagated
     *
     * @return          String $error                   Compiled error message with time-stamp and constants parsed through this method's params
     */
    public function error($msg, $class, $fn, $ln, $fl) {
        // Build: error message
        $error  = $this->get_date() . "| <h3>[ERROR] \"$msg\"</h3>" . PHP_EOL;    // Head
        $error .= "    LIN: #$ln - $class::$fn()" . PHP_EOL;                  // Body
        $error .= "    SRC: \"$fl\"" . PHP_EOL;                               // Foot

        $this->log($error);                             // Log: error in 'waffle.error.log'

        return $error;
        // exit($error);
    }
}
?>