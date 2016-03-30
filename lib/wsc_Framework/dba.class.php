<?php
/**
* Database Adapter
*
* Includes various methods to establish a connection as well as communicate (or query) a database
* for pre-specified data.
*
* @subpackage   Database Adapter
* @category     Adapter
* @author       Justin D. Byrne <justinbyrne001@gmail.com>
*/

namespace WSC\Framework\Adapters;

use WSC\Framework\Adapters\DBA;
use WSC\Framework\Agents\sqlLog;

require_once ("sqlLog.class.php");

class DBA extends sqlLog {
    /**
     * @var             {String} host                   Host: address name
     * @var             {String} user                   User: name for the database
     * @var             {String} pass                   Password: for the database
     * @var             {String} db                     Database: name to which a connection will be established
     * @var             {String} cxn                    Connection: to the database ? if a connection is established
     */
    protected $host = "127.0.0.1";
    protected $user = "wscAdmin";
    protected $pass = "password01";
    protected $db   = "williams";
    protected $cxn;

    /**
     * Constructor      {Constructor}                    Attempt: to establish a connection with the database
     */
    public function __construct() {
        $this->cxn = mysqli_connect($this->host, $this->user, $this->pass, $this->db);
        (!$this->cxn) ? $this->cxn_failure() : $this->cxn_success();
    }

    /**
     * query            {Method}
     * @param           {String} statement              SQL: statement to be used to manipulate data in the database
     */
    public function query($statement) {
        $result=$this->cxn->query($statement);
        (!$result) ? $this->query_failure() : $this->query_success();
        $this->cxn->close();
        return $result;
    }
}
?>