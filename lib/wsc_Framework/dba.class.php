<?php
/**
* Includes various methods to establish a connection as well as communicate (or query) a database
* for pre-specified data.
*
* @package      Database Adapter\SQL Logging
* @category     Adapter
* @author       Justin D. Byrne <justin@byrne-systems.com>
*/

namespace WSC\Framework\Adapters;

use WSC\Framework\Adapters\DBA;
use WSC\Framework\Agents\sqlLog;

require_once __DIR__ . '/../../inc/psl-config.php';
require_once 'sqlLog.class.php';

/**
 * Database Adapter
 *
 * HTML Generator that outputs semantic HTML tags wrapped around the any content passed.
 */
class DBA extends sqlLog {
    /**
     * MYSQLi Database Connection object
     *
     * @access          protected
     * @var             Object $cxn                     MYSQLi Database connection
     */
    protected $cxn;

    /**
     * Attempt: to establish a connection with the database
     *
     * @param           String $host                    Host name of the intended database
     * @param           String $user                    User (or admin) to sign into the intended database with
     * @param           String $pass                    Password (or phrase) for the user signing into the intended database
     * @param           String $db                      The intended database's name
     */
    public function __construct()
    {
        $this->cxn = mysqli_connect(HOST, USER, PASSWORD, DATABASE);
        (!$this->cxn) ? $this->cxn_failure(DATABASE) : $this->cxn_success(DATABASE);
    }

    /**
     * [prepare description]
     * @param  [type] $statement [description]
     * @param  [type] $param     [description]
     * @return [type]            [description]
     */
    public function prepare($statement, $param)
    {
        if ($prep = mysqli_prepare($this->cxn, $statement)) {
            mysqli_stmt_bind_param($stmt, "s", $param); # Bind: parameters for markers

            mysqli_stmt_execute($stmt);                 # Execute: query

            mysqli_stmt_bind_result($stmt, $result);    # Bind: result variables

            mysqli_stmt_fetch($stmt);                   # Fetch: value

            mysqli_stmt_close($stmt);                   # Close: statement
        }

        return $result;
    }

    /**
     * Queries the open DB connection with the passed SQL statement
     *
     * @param           String $statement               SQL statement to be used to manipulate data in the database
     * @return          String                          Resulting query
     */
    public function query($statement)
    {
        $result=$this->cxn->query($statement);
        (!$result) ? $this->query_failure() : $this->query_success();
        $this->cxn->close();

        return $result;
    }

    /**
     * [store_array description]
     *
     * @param           String &$data                   Data to be inserted into database
     * @param           String $table                   Table to which the data (passed) should be inserted
     * @param           Object $mysqli                  MySQLi connection object
     * @return          NULL                            Inserts the 'data' passed into the 'table' passed
     */
    private function store_array (&$data, $table, $mysqli)
    {
        $cols = implode(',', array_keys($data));

        foreach (array_values($data) as $value) {
            isset($vals) ? $vals .= ',' : $vals = '';
            $vals .= '\''.$this->mysql->real_escape_string($value).'\'';
        }

        $mysqli->real_query('INSERT INTO '.$table.' ('.$cols.') VALUES ('.$vals.')');
    }

}