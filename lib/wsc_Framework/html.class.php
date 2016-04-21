<?php
/**
 * Generates various HTML specific semantic tags that can be implemented throughout any WSC
 * web-document or application.
 *
 * @package     HTML Tag Generator
 * @category    Engines
 * @author      Justin D. Byrne <justin@byrne-systems.com>
 */

namespace WSC\Framework\Engines;

use WSC\Framework\Engines\HTML;
use WSC\Framework\Handlers\Validation;

require_once 'validation.class.php';

/**
 * HTML Tag Generator
 *
 * HTML Generator that outputs semantic HTML tags wrapped around the any content passed.
 */
abstract class HTML {
    /**
     * Returns a pre-assigned (absolute path) domain-name that is the domain URL for byrne-systems
     *
     * @method String get_domain()
     *
     * @return          String                          Pre-assigned domain-name
     */
    private function get_domain() { return 'http://www.byrne-systems.com/'; }

    /**
     * Determines whether the '$rule' passed is to declare a 'name' or 'http-equiv' attribute for a
     * meta tag.
     *
     * @method String meta_type(String $rule, String $name)
     *
     * @param           String $ext                     Extension type (or keyword) to be used when parsing the meta-tag
     * @return          String                          The result of the parsed meta name
     */
    private function meta_type($ext) {
        $r = ($ext[0] == "!") ?
             ' http-equiv="' . ltrim($ext,'!') . '"' :
             ' name="' . $ext . '"';

        return $r;
    }

    /**
     * Parse the correct type (or identifier) for CSS and HTML link targeting
     *
     * @method String parse_id_type(String $rule)
     *
     * @param           String $rule                    The rule that defines how to parse the associated HTML element
     * @return          String                          The correct type or identifier determined for the parsed rule
     */
    private function parse_id_type($rule) {
        $result = null;

        if (is_array($rule)) {
            $result = ' class="';
            foreach ($rule as $value) {
                $class   = substr($value, 1, strlen($value));
                $result .= $class . ' ';
            }

            $result = rtrim($result) . '"';
        }

        if ($rule[0] == "#") {
            $id     = substr($rule, 1, strlen($rule));
            $result = ' id="' . $id . '"';
        }

        if ($rule[0] == ".") {
            $class  = substr($rule, 1, strlen($rule));
            $result = ' class="' . $class . '"';
        }

        if ($rule[0] == "_") {
            $target = substr($rule, 1, strlen($rule));
            $result = ' target="' . $target . '"';
        }

        return $result;
    }

    /**
     * Verifies whether the email passed is wrapped in an array, then parses the address to comply
     * with proper mailto hypertext syntax standards. This function is primarily used to parse email
     * addresses mailto, cc, and bcc for this classes "mailto" method
     *
     * @param           String|Array $email             A recipients email address (i.e., mailto, cc, or bcc) sent via the mailto method
     * @return          String                          Parsed email address to be inserted into a mailto hypertext link
     */
    private function parse_mailto_addresses($email) {
        $r = NULL;

        if (!is_array($email)) {
            $r .= $email;
        } else {
            foreach ($email as $address) { $r .= $address . ','; }
            $r  = rtrim($r, ',');
        }

        return $r;
    }

    ////////////////////// Public //////////////////////

    /**
     * Generates an internal or external HTML hypertext link
     *
     * @method String anchor() anchor(String $href, String $content, String $title, String $id)
     *
     * @param           String $href                    Defines a URL to open when this element is clicked
     * @param           String $content                 Content enclosed between the tags of the generated link (i.e., <a>content</a>)
     * @param           String $title                   Sets the title of the generated hypertext link
     * @param           Array/String $id                Sets a target (where to open linked document) or (either) an id or a class attribute for styling
     * @return          String                          The generated hypertext link
     */
    public function anchor($href, $content, $title, $descriptor) {
        $href_type = substr($href, 0, 4);

        $dmn = ($href_type !== 'http') ? $this->get_domain() . $href : $href;

        $href = filter_var($dmn, FILTER_SANITIZE_STRING);

        $data  = '<a href="' . $href . '"';
        $data .= (isset($title) ? ' title="' . $title . '"': ' title="' . $content . '"');

        $data .= $this->parse_id_type($descriptor);

        $data .= '>';
        $data .= $content;
        $data .= '</a>';

        return $data;
    }

    /**
     * [div description]
     * @param  [type] $content    [description]
     * @param  [type] $descriptor [description]
     * @return [type]             [description]
     */
    public function div($content, $descriptor) {
        $div = '<div';
        $div .= $this->parse_id_type($descriptor);
        $div .= '>' . $content . '</div>';

        return $div;
    }

    /**
     * Generates a mailto hypertext link to mail content to a single (or several) an email
     * address(es)
     *
     * @method String mailto() mailto(String $email, String $content, String $title, String aux)
     *
     * @param           String|Array $mailto            Recipient's e-mail address(es)
     * @param           String|Array $cc                Carbon copy e-mail address(es)
     * @param           String|Array $bcc               Blind carbon copy e-mail address(es)
     * @param           String $sub                     Subject corresponding to the e-mail(s) prepped for this link
     * @param           String $body                    Body (or content) for the e-mail(s) being prepped for this link
     * @param           String $content                 Content enclosed between the tags of this generated link
     * @return          String                          Generated mailto link
     */
    public function mailto($mailto , $cc, $bcc, $sub, $body, $content) {
        $v = new Validation;                            // Instantiate: a new Validation object

        // Do: wrapper to initiate various comparison tests to authenticate that the proper content
        // exists to parse the proper mailto output
        do {
            $link = '<a href="';

            if (!isset($mailto) || empty($mailto)) {
                $link = $v->error('Standard Email not found!', __CLASS__, __FUNCTION__, __LINE__, __FILE__);
                break;  // Exit: Do while loop
            } else {
                if (!$v->email_format($mailto) === false) {
                    $link .= 'mailto:' . $this->parse_mailto_addresses($mailto) . '?';
                }
            }   // end - mailto validation

            if (isset($cc)) {
                if (!$v->email_format($cc) === false) {
                    $link .= 'cc=' . $this->parse_mailto_addresses($cc) . '&amp;';
                }
            }   // end - $cc validation

            if (isset($bcc)) {
                if (!$v->email_format($bcc) === false) {
                    $link .= 'bcc=' . $this->parse_mailto_addresses($bcc) . '&amp;';
                }
            }   // end - $bcc validation

            if (isset($sub)) {
                $sub   = str_replace(' ', '%20', $sub);
                $link .= 'subject=' . $sub . '&amp;';
            }

            if (isset($body)) {
                $body  = str_replace(' ', '%20', $body);
                $link .= 'body=' . $body;
                $link .= '">' . $content . '</a>';
            }

            return $link;
        } while (0);
    }

    /**
     * Generates a Meta tag that provides metadata about the HTML document generated and served
     *
     * @method String meta(String $name, String $content)
     *
     * @param           String $name                    They key set here is either a 'http-equiv' header for the info/value pair or a 'name' part of the name/value pair.
     * @param           String $content                 The content which gives the value associated with the 'http-equiv' or 'name' attribute.
     * @return          String                          Generated <meta> tag.
     */
    public function meta($name, $content) {
        $v = new Validation;                            // Instantiate: a new Validation object

        do {
            // Identify: whether the name passed is intended to be a "http-equiv" or a "name"
            if (!isset($name) || empty($name)) {
                $data = $v->error('No meta tag set!', __CLASS__, __FUNCTION__, __LINE__, __FILE__);
                break;
            } else {
                $name = (is_string($name)) ? $this->meta_type($name) : '';
                $data =  '<meta' . $name . ' content="' . $content . '">';
            }

            return $data;
        } while (0);
    }

    /**
     * Generates an internal <script> tag to define client-side script; such as JavaScript
     *
     * @method String script(String $src, String $type, String $type, Boolean $defer, String $charset)
     *
     * @param           String  $src                    The source of the file, module, or program to load
     * @param           String  $type                   The media type for the generated script
     * @param           Boolean $defer                  Sets whether the script is meant to be executed after the documented as been parsed
     * @param           String  $charset                Sets the character encoding of an external script; For external scripts "only"!
     * @return          String                          A generated script tag parsed by using the passed parameters values
     *
     * @todo add attributes: Integrity, Async [HTML5], and Crossorigin
     */
    public function script($src, $type = false, $defer = false, $charset = false) {
        $data  = '<script';

        $data .= ($type) ? ' type="' . $type . '"' : NULL;                                          # $type
        $data .= ' src="' . $src . '"';                                                             # $src
        $data .= ($charset) ? ' charset="' . $charset . '"' : NULL;                                 # $charset
        $data .= ($defer) ? ' defer' : NULL;                                                        # $defer

        $data .= '>';
        $data .= '</script>';

        return $data;
    }

    /**
     * Generic tag method that generates generic HTML tags passed via it's secondary parameter through using the content and tag data passed
     *
     * @method String tag(String $content, String $tag)
     *
     * @param           String $content                 The content that will be wrapped in the generated tag
     * @param           String $tag                     The tag to be used while generated the generic HTML content
     * @return          String                          Returns a concatenated (single) string resulting in a generated meta tag with the passed content enclosed inside
     */
    public function tag($content, $tag, $descriptor = null) {
        $result  = '<' . $tag;
        $result .= (isset($descriptor)) ? $this->parse_id_type($descriptor) : null;
        $result .= '>' . $content . '</' . $tag . '>';

        return $result;
    }
}
?>