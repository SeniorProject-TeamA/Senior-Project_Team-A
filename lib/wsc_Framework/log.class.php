<?php
/**
 * [Description]
 *
 * @package     Error\Log
 * @category    Agent
 * @author      Justin D. Byrne <justinbyrne001@gmail.com>
 */

namespace WSC\Framework\Agents;

use WSC\Framework\Agents\Log;

/**
 * Log Agent
 *
 * [Description]
 */
class Log {
    /**
     * Log: error message in [data/logs/wsc.error.log] after shipping any HTML and/or PHP tags
     *
     * @param           String                          Message to display on the browser and write to [wsc.error.log]
     */
    public function log($msg) {
        $dir = '..\\..\\..\\data\\logs\\';

        $msg  = strip_tags($msg) . PHP_EOL;             // Strip: all HTML & PHP tags
        $path = __DIR__ . $dir . "wsc.error.log";

        error_log($msg, 3, $path);
    }
}
?>