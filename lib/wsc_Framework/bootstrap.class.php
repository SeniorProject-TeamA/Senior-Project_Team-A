<?php
/**
 * Bootstrap Component Markup Assembler that parses native bootstrap component markup, containers,
 * rows, columns, and elements.
 *
 * @package      HTML\Boostrap
 * @category     Assembler
 * @author       Justin D. Byrne <justinbyrne001@gmail.com>
 */

namespace WSC\Framework\Engines;

use WSC\Framework\Engines\Boostrap;
use WSC\Framework\Engines\HTML;

require_once 'html.class.php';

/**
 * Bootstrap component Markup Assembler
 *
 * Parses native bootstrap component markup, containers, rows, columns, and other elements.
 *
 * @package     HTML\Boostrap
 */
class Bootstrap extends HTML {
    /**
     * [container description]
     *
     * @param           String $content                 Content to be wrapped by this function
     * @param           String $type                    Defines the type of container; i.e., 'fluid' or 'fixed'
     * @return          String                          [description]
     */
    public function container($content, $type = 'fixed') {
        $result = '<div class="';

        switch ($type) {
            case 'fixed':
                $result .= 'container' . '">' . $content . '</div>';
                break;
            case 'fluid':
                $result .= 'container-fluid' . '">' . $content . '</div>';
                break;
            default:
                $result = 'error';
                break;
        }

        return $result;
    }

    /**
     * [row description]
     *
     * @param           String $content                 Content to be wrapped by this function
     * @return          String                          [description]
     */
    public function row($content) {
        return '<div class="row">' . $content . '</div>';
    }

    /**
     * [column description]
     *
     * @param           Integer $amount                 Amount of columns to attribute to the columns being set
     * @param           String  $size                   Size of the columns being set; xs, sm, md, & lg
     * @param           String  $content                Content to be wrapped by this function
     * @return          String                          [description]
     */
    public function column($amount = 12, $size = 'sm', $content) {
        return '<div class="col-' . $size . '-' . $amount . '">' . $content . '</div>';
    }

    /**
     * Generates and parses a viewport meta tag for Bootstrap; or Responsive Web Design
     *
     * @method String viewport(Array $options)
     *
     * @param           Array $options                  Array containing the various properties available throughout a viewport tag
     * @return          String                          Returns a meta tag to set the viewport for a particular web-document, site, or application
     */
    public function viewport($options = array('width' => 'device-width', 'height' => NULL, 'initial-scale' => 1, 'minimum-scale' => NULL, 'maximum-scale' => NULL, 'user-scalable' => 'no')) {
        $content    = 'content="';

        if (!array_filter($options)) {
            $view = 'error';
        } else {

            foreach ($options as $key => $option) {
                if (isset($option)) $content .= "$key=$option, ";
            }

            $content = rtrim($content, ', ');
            $view    = '<meta name="viewport" ' . $content . '">';
        }

        return $view;
    }
}
?>