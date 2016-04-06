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
        switch ($type) {
            case 'fixed':
                $result = $this->div($content, '.container');
                break;
            case 'fluid':
                $result = $this->div($content, '.container-fluid');
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
        return $this->div($content, '.row');
    }

    /**
     * Generates Bootstrap column(s) while denoting its size as content is passed through
     *
     * @method String column(Integer $amount, String $size, String $content)
     *
     * @todo Write Error Code!
     *
     * @param           Integer $amount                 Amount of columns to attribute to the columns being set; (i.e., 1, 2, 3...12)
     * @param           String  $size                   Size of the columns being set; (i.e., xs, sm, md, or lg)
     * @param           String  $content                Content to be wrapped by this function
     * @return          String                          [description]
     */
    public function column($amount = 12, $size = 'sm', $content, $alt = NULL) {
        $class = '.col-' . $size . '-' . $amount;

        // Verifies: whether '$alt' is an array
        if ($alt) {
            $descriptors = array($class, $alt);
            if (is_array($alt)) {
                $descriptors = array($class);
                foreach ($alt as $key) array_push($descriptors, $key);
            }
            $class = $descriptors;
        }

        return $this->div($content, $class);
    }

    /**
     * [panel description]
     *
     * @method String panel(String $type, String $caption, String $content, Array/String $alt)
     *
     * @param           String $type                    Type of panel to generate; either 'header' or 'footer'
     * @param           String $caption                 Caption to be placed inside of its corresponding header (or footer)
     * @param           String $content                 Content to be stored inside of the body of this Bootstrap element
     * @param           Array/String $alt               Alternative (or Additional) classes to affix to this panel's body
     * @return          String                          [description]
     */
    public function panel($type = 'header', $caption, $content, $alt = NULL) {
        $descriptors = array('.panel-body');

        // Verifies: whether '$alt' is an array
        if (!$alt) {
            $body = $this->div($content, '.panel-body');
        } else {
            if (!is_array($alt)) {
                array_push($descriptors, $alt);
            } else {
                foreach ($alt as $key) array_push($descriptors, $key);
            }

            $body = $this->div($content, $descriptors);
        }

        // Identifies: whether panel is header or footer oriented
        switch ($type) {
            case 'header':
                $head   = $this->div($caption, '.panel-heading');
                $result = $this->div($head . $body, $descriptors = array('.panel', '.panel-default'));
                break;
            case 'footer':
                $foot   = $this->div($caption, '.panel-footer');
                $result = $this->div($body . $foot, $descriptors = array('.panel', '.panel-default'));
                break;
            default:
                $result = 'error';
                break;
        }

        return $result;
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
        $content = 'content="';

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