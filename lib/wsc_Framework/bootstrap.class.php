<?php
/**
 * Bootstrap Component Markup Assembler that parses native bootstrap component markup, containers,
 * rows, columns, and elements.
 *
 * @package      HTML\Boostrap
 * @category     Assembler
 * @author       Justin D. Byrne <justinbyrne001@gmail.com>
 */

namespace WSC\Framework\Assemblers;

use WSC\Framework\Assemblers\Boostrap;

/**
 * Bootstrap component Markup Assembler
 *
 * Parses native bootstrap component markup, containers, rows, columns, and other elements.
 *
 * @package     HTML\Boostrap
 */
class Bootstrap {
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