<?php
/**
 * Validate login credentials from the 'login.wad' parsed form console
 *
 * @package     Validate Login
 * @category    Agent
 * @author      Justin D. Byrne <justin@byrne-systems.com>
 */

require 'psl-config.php';
require '/../lib/wsc_Framework/session-manager.class.php';
require '/../lib/wsc_Framework/validation.class.php';

use WSC\Framework\Controls\SessionManager;
use WSC\Framework\Handlers\Validation;

$sm = new SessionManager;
$sm->session_timeout();

$v = new Validation;

if (isset($_POST['empID'], $_POST['p'])) {
    $mysqli = new mysqli(HOST, USER, PASSWORD, DATABASE);

    session_start();

    if ($v->login($_POST['empID'], $_POST['p'], $mysqli)) {
        header("Location: http://localhost/", TRUE, 307);
    } else {
        header("Location: ../logout.php?err=Invalid password submitted; please try again!", TRUE, 307);
    }
}

// var_dump($_SESSION);    # [TEMP]