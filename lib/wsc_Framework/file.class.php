<?php
/**
 * Parses files contents prior to writing, modifying, or returning contents once read from source.
 *
 * @package     File\Validation
 * @category    Handler
 * @author      Justin D. Byrne <justin@byrne-systems.com>
 */

namespace WSC\Framework\Handlers;

use WSC\Framework\Handlers\File;
use WSC\Framework\Handlers\Validation;

require_once 'validation.class.php';

/**
 * File Handler
 *
 * Class designed to handle various file read, write, and modify methods
 */
class File extends Validation {
    /**
     * Reads an assortment of flat file types to be returned to the originating method
     *
     * @method Mixed read(String $file, Mixed $return_type, $String $key)
     *
     * @param           String $file                    Filename (and/or directory) of the file to be returned to the originating method
     * @param           Mixed  $rtn_tp                  Return type or the variable type to return the requested file
     * @param           String $latchkey                Credential(s) to pass to decrypt file, if necessary
     * @return          Mixed                           Contents of the requested file
     */
    public function read($file, $rtn_tp, $latchkey) {
        if (file_exists($file)) {

        }
    }

    /**
     * Forces a download on the client-side using this server-side method
     *
     * @method Mixed download(String $file)
     *
     * @param           String $file                    Filename (and/or directory) of the file to be returned/downloaded on the client's system
     * @return          Mixed                           The requested file
     */
    public function download($file) {
        if (file_exists($file)) {
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename="'.basename($file).'"');
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($file));
            readfile($file);
            exit;
        }
    }

    /**
     * Writes passed content into the filename passed @params appended after the filename's
     * last entry
     *
     * @method Boolean write(String $file, String $content, String $type)
     *
     * @param           String $file                description
     * @param           String $content                 description
     * @param           String $type                    description
     * @return          Boolean                         description
     */
    public function write($file, $content, $type = 'file') {
        $dir  = '/../../data/';
        $mode = 'a';

        if (isset($file) && isset($content)) {
            switch ($type) {
                case 'file':
                    $file = __DIR__ . $dir . $file;
                    break;
                case 'log':
                    $file = __DIR__ . $dir . $type . 's/' . $file  . '.log';
                    break;
                case 'json':
                    $file = __DIR__ . $dir . $type . '/' . $file . '.json';
                    $content = json_encode($content, JSON_UNESCAPED_SLASHES);                       # -Flag: JSON_UNESCAPED_SLASHES: don't insert '\' slashes throughout Array|String
                    $mode = 'w';                        # Mode: open for R/W, while placing pointer at beginning of file after truncating file to zero length
                    break;
                default:
                    $this->error('Improper (or unknown) filetype passed!', __CLASS__, __FUNCTION__, __LINE__, __FILE__);
                    return false;
                    break;
            }

            $file = fopen($file, $mode);
            fwrite($file, $content . PHP_EOL);
            fclose($file);                              # Close: file
        }
        return true;
    }
}