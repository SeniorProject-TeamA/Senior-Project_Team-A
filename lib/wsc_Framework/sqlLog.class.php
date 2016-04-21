<?php
/**
* SQL Logging Agent
*
* This class logs all SQL transmissions into a single (appended) flat file stored
* in '/data/logs'
*
* @package      SQL Logging
* @category     Agent
* @author       Justin D. Byrne <justin@byrne-systems.com>
*/

namespace WSC\Framework\Agents;

use WSC\Framework\Agents\sqlLog;

/**
 * SQL Logging Agent
 *
 * Logs SQL transmissions into a single flat file
 */
class sqlLog {
    protected $root;

    public function __construct()
    {
        $this->root = rtrim(dirname(__FILE__), '/lib/wsc_Framework');
    }

    /**
     * Returns the current date for logging, indexing, or anything else requiring a time-stamp
     *
     * @return          String                          Return: current time; correctly formatted
     */
    private function get_date()
    {
        date_default_timezone_set('America/Los_Angeles');
        return "[ " . date('l jS \of F Y h:i:s A') . "] ";
    }

    /**
     * Generates a successful connection message in a human readable (and writable) format
     *
     * @param           Object $db                      Database connection object
     * @return          NULL                            Writes contents to flat-file in '/data/logs'
     */
    public function cxn_success($db)
    {
        $content  = $this->get_date() . "[success] a proper connection to MySQL was made!" . PHP_EOL;
        $content .= $this->get_date() . "Properly connected to " . $db . " database."      . PHP_EOL;
        $content .= $this->get_date() . "Host: " . mysqli_get_host_info($this->cxn)        . PHP_EOL;

        $this->write_file($content);
    }

    /**
     * Generates a successful query message in a human readable (and writable) format
     *
     * @return          NULL                            Writes contents to flat-file in '/data/logs'
     */
    public function query_success()
    {
        $content = $this->get_date() . "[success] query executed successfully" . PHP_EOL;
        $this->write_file($content);
    }

    /**
     * Generates a connection failure message in a human readable (and writable) format
     *
     * @return          NULL                            Writes contents to flat-file in '/data/logs'
     */
    public function cxn_failure()
    {
        $content = $this->get_date() . "[error] unable to connect to MySql." . PHP_EOL;
        $this->log_error($content);
    }

    /**
     * Generates a query failure message in a human readable (and writable) format
     *
     * @return          NULL                            Writes contents to flat-file in '/data/logs'
     */
    public function query_failure()
    {
        $content = $this->get_date() . "[error] query failed to execute!" . PHP_EOL;
        $this->log_error($content);
    }

    /**
     * Generates an error message in a human readable (and writable) format while attempting to capture
     * a representative MySQLi Error Number (mysqli_errno) to parse to a file, db, or stdout
     *
     * @param           String $content                 Human readable written content (or message) to write; or log
     * @return          NULL                            Writes contents to flat-file in '/data/logs'
     */
    public function log_error($content)
    {
        if (mysqli_errno) {
            $content .= $this->get_date() . mysqli_error($this->cxn) . PHP_EOL;
        } else {
            $content .= $this->get_date() . "[debugging] Errno: " . mysqli_errno() . PHP_EOL;
            $content .= $this->get_date() . "[debugging] Error: " . mysqli_error() . PHP_EOL;
        }

        $this->write_file($content);
        $this->cxn->close();
    }

    /**
     * Appends data log 'sql.db.log' located at '/data/logs' using the pre-parsed content; passed
     *
     * @param           String $content                 Content to be written to log file
     * @return          NULL                            Writes the pre-parsed content into the 'sql.db.log' log file
     */
    public function write_file($content)
    {
        $file = fopen($this->root . "data/logs/" . "sql.db.log", "a");
        fputs($file, $content);
        fclose($file);
    }
}

?>