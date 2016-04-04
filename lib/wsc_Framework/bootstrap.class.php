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
    //  width'          => NULL,                   # Width of the viewport in pixels                   | Default(980); Range(200, 10,000)
    //  height'         => NULL,                   # Height of the viewport in pixels                  | Range(223, 10,000)
    //  device-width'   => 1,                      # The width of the device in pixels                 | 'device-width'
    //  device-height'  => NULL,                   # The height of the device in pixels                | 'device-height's
    //  initial-scale'  => 1,                      # Initial scale of the viewport as a multiplier     | Range($min_scale, $max_scale)
    //  minimum-scale'  => 1,                      # Specifies the minimum scale value of the viewport | Default(0.25); Range(>0, 10.0)
    //  maximum-scale'  => 1,                      # Specifies the maximum scale value of the viewport | Default(5.00); Range(>0, 10.0)
    //  user-scalable'  => 'no',                   # Determines whether the user can zoom in and out   | Default('yes'); Options('no', 'yes')

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