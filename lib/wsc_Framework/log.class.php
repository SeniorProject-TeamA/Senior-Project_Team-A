<?php
/**
 * Rudimentary logging agent that ensures that stdout error messages are cleared (or stripped)
 * of any HTML and/or PHP tags, then writes result(s) to a local log file 'wsc.error.log'
 *
 * @package     Log
 * @category    Agent
 * @author      Justin D. Byrne <justin@byrne-systems.com>
 */

namespace WSC\Framework\Agents;

use WSC\Framework\Agents\Log;

/**
 * Logging Agent
 *
 * Writes a human readable log file 'wsc.error.log' in '/data/logs'
 */
class Log {
    /**
     * Log: error message in [data/logs/wsc.error.log] after shipping any HTML and/or PHP tags
     *
     * @param           String                          Message to display on the browser and write to [wsc.error.log]
     * @return          NULL                            Logs error message passed through params
     */
    public function log($msg) {
        $dir = '..\\..\\..\\data\\logs\\';

        $msg  = strip_tags($msg) . PHP_EOL;             // Strip: all HTML & PHP tags
        $path = __DIR__ . $dir . "wsc.error.log";

        error_log($msg, 3, $path);
    }
}
?>