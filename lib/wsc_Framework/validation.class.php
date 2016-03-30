<?php
/**
 * Endorses that specific content, input, or data is appropriately organized and/or formatted prior
 * to advancing intermediate subroutines.
 *
 * @package     Validation
 * @category    Agent
 * @author      Justin D. Byrne <justin@byrne-systems.com>
 */

namespace WSC\Framework\Handlers;

use WSC\Framework\Handlers\Validation;
use WSC\Framework\Handlers\Error;

require_once 'error.class.php';

/**
 * Validation Agent
 *
 * Confirms that transmitted data meets specific criterion prior to allowing a transitional method
 * to progress.
 */
class Validation extends Error {
    /**
     * [description]
     *
     * @param  [type] $file [description]
     * @return [type]       [description]
     */
    public function check_file($file) {
        $result = NULL;

        $ext = ltrim(pathinfo($file, PATHINFO_EXTENSION), '.');     # Isolate: packages file extension
        $nfo = pathinfo($file);                                     # Get: info regarding package's file directory, base-name, extension, and name

        $result = ($nfo['extension'] === $ext) ? true : false;

        return $result;
    }

    /**
     * Validates whether the email passed is a properly formatted email address
     * (i.e., email@server.net)
     *
     * @method Boolean email_format(String $email)
     *
     * @param           String $email                   E-mail address to validate
     * @return          Boolean                         Result of validation test
     */
    public function email_format($email) {
        $r = false;

        if (is_array($email)) {
            foreach ($email as $address) {
                $r = (!filter_var($address, FILTER_VALIDATE_EMAIL) === false) ? true : false;
            }
        } else {
            $r = (!filter_var($email, FILTER_VALIDATE_EMAIL) === false) ? true : false;
        }

        return $r;
    }
}
?>