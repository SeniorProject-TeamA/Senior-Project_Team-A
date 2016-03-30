<?php
/**
* This class logs all SQL transmissions
*
* @package      sqlLog
* @category     Agent
* @author       James R. Coltman <iamthecoltman@gmail.com>
*/

namespace WSC\Framework\Agents;

use WSC\Framework\Agents\sqlLog;

class sqlLog {

    /**
     * get_date         {Method}
     * @return          {String}                        Return: the current time, correctly formatted
     */
    private function get_date() {
        date_default_timezone_set('America/Los_Angeles');
        return "[ " . date('l jS \of F Y h:i:s A') . "] ";
    }

    /**
     * cxn_success      {Method}
     * @return [type] [description]
     */
    public function cxn_success() {
        $content  = $this->get_date() . "[success] a proper connection to MySQL was made!" . PHP_EOL;
        $content .= $this->get_date() . "Properly connected to " . $this->db . " database." . PHP_EOL;
        $content .= $this->get_date() . "Host: " . mysqli_get_host_info($this->cxn) . PHP_EOL;

        $this->write_file($content);
    }

    public function query_success() {
        $content = $this->get_date() . "[success] query executed successfully" . PHP_EOL;
        $this->write_file($content);
    }

    public function cxn_failure() {
        $content = $this->get_date() . "[error] unable to connect to MySql." . PHP_EOL;
        $this->log_error($content);
    }

    public function query_failure() {
        $content = $this->get_date() . "[error] query failed to execute!" . PHP_EOL;
        $this->log_error($content);
    }

    public function log_error($content) {
        if (mysqli_errno) {
            $content .= $this->get_date() . mysqli_error($this->cxn) . PHP_EOL;
        } else {
            $content .= $this->get_date() . "[debugging] Errno: " . mysqli_errno() . PHP_EOL;
            $content .= $this->get_date() . "[debugging] Error: " . mysqli_error() . PHP_EOL;
        }

        $this->write_file($content);
        $this->cxn->close();
    }

    public function write_file($content) {
        $file = fopen("sql_db.log", "a");
        fputs($file, $content);
        fclose($file);
    }
}

?>