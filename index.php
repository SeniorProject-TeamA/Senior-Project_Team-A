<?php
/**
 * WSC DESCRIPTION!
 *
 * @package     WSC
 * @author      Justin D. Byrne <justin@byrne-systems.com>
 * @version     0.1 [In development]
 * @copyright   2016
 */

# Load Controller
require_once '/inc/controller.php';

# Parse Application
echo $app->output();

include 'inc/debug/session_debug.php';                  # [TEMP]