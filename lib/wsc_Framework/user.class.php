<?php
/**
* This class is used for setting up new user's
*
* @package      User
* @category     Agent
* @author       James R. Coltman <iamthecoltman@gmail.com>
*/

namespace WSC\Framework\Agents;

use WSC\Framework\Agents\User;

/**
 * [description]
 *
 * [Detailed Description]
 */
class User {
    private $user;
    private $pass;
    private $jobtitle;
    private $db;

    /**
     * [__construct description]
     * @param [type] $user [description]
     */
    public function __construct($user) {
        // echo "Class: (" . CLASS . ") Instantiated!" . PHP_EOL;

        $this->setUser($user);

        $this->setPass($db->getPass($user));

        $this->setJobTitle($db2->getJobTitle($user));
    }

    /**
     * Set's user
     *
     * @param   String $user                            Name of the user
     */
    private function setUser($user) {
        $this->user = $user;
    }

    /**
     * [setPass description]
     * @param [type] $pass [description]
     */
    private function setPass($pass) {
        $this->pass = $pass;
    }

    /**
     * [setJobTitle description]
     * @param [type] $jobTitle [description]
     */
    private function setJobTitle($jobTitle) {
        $this->jobTitle = $jobTitle;
    }

    /**
     * [getUser description]
     * @return [type] [description]
     */
    public function getUser() {
        return $this->user;
    }

    /**
     * [getPass description]
     * @return [type] [description]
     */
    public function getPass() {
        return $this->pass;
    }

    /**
     * [getJobTitle description]
     * @return [type] [description]
     */
    public function getJobTitle() {
        return $this->jobTitle;
    }
}

?>