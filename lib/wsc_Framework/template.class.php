<?php
/**
 * Templating engine developed to substitute special WSC tags while publishing a clean HTML document
 *
 * @package     Template Engine\HTML Tag Generator
 * @category    Engine
 * @author      Justin D. Byrne <justin@byrne-systems.com>
 */

namespace WSC\Framework\Engines;

use WSC\Framework\Engines\Template;
use WSC\Framework\Engines\HTML;

require_once 'html.class.php';

/**
 * MVC Templating Engine
 *
 * Templating engine that generates HTML files utilizing WSC's view's, or ".wad" files
 */
class Template extends HTML {
    /**
     * Template filename to load, and eventually parse via this template engine
     *
     * @access          protected
     * @var             String $file
     */
    protected $file;

    /**
     * The value of each template tag (e.g., [!tag]) authored throughout each template file (e.g., *.wad)
     *
     * @access          protected
     * @var             Array $values
     */
    protected $values = array();

    /**
     * Constructor method used to instantiate a new Template object after passing its associate file.
     *
     * @param           String $file                    The filename of the template file to load
     */
    public function __construct($file) { $this->file = $file; }

    /**
     * Sets the value to replace the specific tag passed through this function.
     *
     * @param           String $key                     The key used to identify the template tag (e.g., [!temp_tag]) to be set
     * @param           String $value                   The value parsed (or supplemented); in correspondence with its key
     */
    public function set($key, $value) { $this->values[$key] = $value; }

    /**
     * Output a correctly formatted HTML (String), after supplementing each template tag identified
     * through each assigned view (*.wad) file.
     *
     * @return          String $output                  Correctly formatted HTML.
     */
    public function output() {
        if (!file_exists($this->file)) {
            return "Error loading template file ($this->file).";
        }

        $output = file_get_contents($this->file);

        foreach ($this->values as $key => $value) {
            $tagToReplace = "[!$key]";
            $output = str_replace($tagToReplace, $value, $output);
        }

        return $output;
    }

    /**
     * Merge multiple templates together to output each template view passed as a single string.
     *
     * @param           Array  $templates               An array of templates to be merged.
     * @param           String $separator               Format each template merged with this separator.
     * @return          String $output                  Output all of the merged (or concatenated) content with the separator passed through.
     */
    static public function merge($templates, $separator = "\n") {
        $output = "";

        foreach ($templates as $template) {
            // Verify: whether '$template' String name (or type) does not equal to "Template" {Class}
            $content = (get_class($template) !== "Template")
                ? "Error, incorrect type - expected Template."
                : $template->output();
            $output .= $content . $separator;
        }

        return $output;
    }
}
?>