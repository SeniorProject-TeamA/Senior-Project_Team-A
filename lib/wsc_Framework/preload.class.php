<?php
/**
 * Pre-loads special code, jobs, libraries, or style-sheets prior to an HTML document (or application)
 * rendering its body (or content).
 *
 * @package     Template Engine\Preload
 * @category    Agent
 * @author      Justin D. Byrne <justin@byrne-systems.com>
 */

namespace WSC\Framework\Agents;

use WSC\Framework\Agents\Preload;
use WSC\Framework\Engines\HTML;

require_once 'html.class.php';

/**
 * Preloading Agent
 *
 * Pre-loads unique code prior to the HTML document (or application) being fully rendered
 */
class Preload extends HTML {
    private $lib_dir = __DIR__ . '\..\\';

    /**
     * Object to contain the Validation Agent, which endorses specific content, input, or data is
     * appropriately organized and/or formatted prior to advancing intermediate subroutines.
     *
     * @var Object
     */
    // protected $Valid;                                   # Reserved: storage space for a 'Validation' Object

    /**
     * Directory tree of the library (or "lib") directory
     *
     * @var Array
     */
    private $dir_tree = array();

    /**
     * An array that holds important configuration data for each element handled by the preloading
     * agent.
     *
     * @var Array
     */
    private $local_paths = array(
        "views"   => "/web/views/",                     # Default Script Directory
        "libs"    => "/../",                            # Relative path for application specific libraries
        "scripts" => "script.wad"                       # Default WSC Script File
    );

    /**
     * Excludes these directories from search
     *
     * @var Array
     */
    private $exclude = array(
        0 => 'stg_Framework',                           # WSC Framework
        1 => 'vendor'                                   # Composer's Vendor Folder
    );

    /**
     * Isolates the appropriate directory that holds the filename passed through the set_script method
     * @method get_lib_dirs
     *
     * @param           Array $array                    An array of strings containing various paths to folders which could hold the desired ancillary code
     * @return          Array $array                    [description]
     */
    private function _get_lib_dirs($array) {
        $lib_directory = $_SERVER['DOCUMENT_ROOT'] . '/lib/';                                       // Get WSC's library directory

        $array = scandir($array);

        // Omit current & parent directory paths
        foreach ($array as $key => $value) {
            if(!preg_match("/(\w)/", $value)) {
                unset($array[$key]);
            }
        }

        // Omit directory listings included throughout the '$exclude' array
        foreach ($array as $key => $value) {
            for ($i = 0; $i < count($this->exclude); $i++) {
                if ($this->exclude[$i] == $value) {
                    unset($array[$key]);
                }
            }
        }

        // Omit file name(s) from $lib_dir
        foreach ($array as $key => $value) {
            if (is_file($lib_directory . '/' . $value)) {
                unset($array[$key]);
            }
        }

        return $array = array_values($array);           // Re-index array
    }

    /**
     * Attempts to locate the filename passed through the set_script method
     *
     * @method String find_file(String $file, String $needle)
     *
     * @param           String $file                    The filename to be recursively searched for throughout the parent directory passed via the __construct'or
     * @return          String $needle                  The directory in which the filename (being searched for) exists
     */
    private function _find_file($file) {
        if (isset($file)) {
            $file = '/' . $file;                        // Prepend: directory division dash

            foreach ($this->dir_tree as $value) {
                $needle = $this->local_paths['views_dir'] . $value . $this->local_paths['script_file'];

                // If: file exists then return to load
                if (file_exists($needle)) {
                    return $needle;
                    break;
                }
            }
        } else {
            return user_error("[error] unable to locate the filename submitted", E_USER_ERROR);
        }
    }

    public function find_file($file) {
        $result = NULL;

        if (!isset($file)) {
            $File->error('empty filename submitted!', __CLASS__, __FUNCTION__, __LINE__, __FILE__);
        } else {
            $result = scandir($this->lib_dir);
        }

        fwrite(STDERR, print_r($result, TRUE));


        return $result;
    }

    ////////////////////// Public //////////////////////

    /**
     * Accepts a directory that holds/stores code, modules, or libraries that can be embedded in the
     * generated WSC web-application or document.
     *
     * @param           String $dir                     Absolute path for the directory to search in for any ancillary code
     */
    public function __construct() {
        // $this->Valid = new Validation;                  # Instantiate: a new 'Validation' object
    }

    /**
     * Returns the requested library files
     *
     * @param           Array|String $pack              Library package(s) to be loaded into the web-document or application
     * @return          [type]                          [description]
     */
    public function get_libs($pack) {
        // $result = ($this->File->check_file($pack)) ? true : false;

        $result = realpath($pack);

        return $result;

        // fwrite(STDERR, print_r($result, TRUE));
        // fwrite(STDERR, print_r($ext, TRUE));
        // fwrite(STDERR, print_r($pack, TRUE));
        // fwrite(STDERR, print_r($pack['extension'], TRUE));
        // return pathinfo($pack);
    }

    /**
     * Locates the exact file passed through the first param of this method while writing it into
     * WSC's default script file [../web/views/script.wad]
     *
     * @todo    Develop file-version logic for method, so that developers can pass a simple filename
     *          in accompaniment with the version that they are attempting to set
     *
     * @method void set_script(String $script, String $ver)
     *
     * @param           String $script                  The filename of the code (or module) to set
     * @param           String $ver                     Version of the file (or filename) to be set
     */
    public function set_script($script, $ver = null) {
        if ($ver == null) {
            $src = $this->find_file($script);

            $src = '/' . strstr($src, 'lib');
            $file = $this->local_paths['views_dir'] . $this->local_paths['script_file'];

            $this->File->write_file($file, $script);
        }
    }
}
?>