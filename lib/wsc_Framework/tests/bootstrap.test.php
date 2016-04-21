<?php
/**
 * testBootstrap : Unit Testing class for "bootstrap.class.php"
 *
 * @package      Boostrap Assembler\testBootstrap
 * @category     UnitTest
 * @author       Justin D. Byrne <justin@byrne-systems.com>
 */

namespace WSC\UnitTests;

use WSC\UnitTests\testBootstrap;
use WSC\Framework\Engines\Bootstrap;

require_once __DIR__ . '/../bootstrap.class.php';

/**
 * @author  Justin D. Byrne <justin@byrne-systems.com>
 */
class testBootstrap extends \PHPUnit_Framework_TestCase {
    protected $boot = NULL;

    /**
     * setUp
     */
    public function setUp()
    {
        $this->boot = new Bootstrap;
    }

    /**
     * viewport_provider : Returns an array that contains various combinations that a user can legally
     * initiate through Bootstrap::viewport
     *
     * @return Array    Array of various user combinations that can be legally initiated
     */
    public function viewport_provider()
    {
        return array(
            array(  #1
                array(
                    'width'         => NULL,            # Width of the viewport in pixels                   | Default(980); Range(200, 10,000)
                    'height'        => NULL,            # Height of the viewport in pixels                  | Range(223, 10,000)
                    'initial-scale' => NULL,            # Initial scale of the viewport as a multiplier     | Range($min_scale, $max_scale)
                    'minimum-scale' => NULL,            # Specifies the minimum scale value of the viewport | Default(0.25); Range(>0, 10.0)
                    'maximum-scale' => NULL,            # Specifies the maximum scale value of the viewport | Default(5.00); Range(>0, 10.0)
                    'user-scalable' => NULL,            # Determines whether the user can zoom in and out   | Default('yes'); Options('no', 'yes')
                ),
                'error'
            ),
            array(  #2
                array(
                    'width'         => 'device-width',
                    'height'        => NULL,
                    'initial-scale' => NULL,
                    'minimum-scale' => NULL,
                    'maximum-scale' => NULL,
                    'user-scalable' => NULL,
                ),
                '<meta name="viewport" content="width=device-width">'
            ),
            array(  #3
                array(
                    'width'         => NULL,
                    'height'        => 'device-height',
                    'initial-scale' => NULL,
                    'minimum-scale' => NULL,
                    'maximum-scale' => NULL,
                    'user-scalable' => NULL,
                ),
                '<meta name="viewport" content="height=device-height">'
            ),
            array(  #4
                array(
                    'width'         => NULL,
                    'height'        => NULL,
                    'initial-scale' => 1,
                    'minimum-scale' => NULL,
                    'maximum-scale' => NULL,
                    'user-scalable' => NULL,
                ),
                '<meta name="viewport" content="initial-scale=1">'
            ),
            array(  #5
                array(
                    'width'         => NULL,
                    'height'        => NULL,
                    'initial-scale' => NULL,
                    'minimum-scale' => 1,
                    'maximum-scale' => NULL,
                    'user-scalable' => NULL,
                ),
                '<meta name="viewport" content="minimum-scale=1">'
            ),
            array(  #6
                array(
                    'width'         => NULL,
                    'height'        => NULL,
                    'initial-scale' => NULL,
                    'minimum-scale' => NULL,
                    'maximum-scale' => 1,
                    'user-scalable' => NULL,
                ),
                '<meta name="viewport" content="maximum-scale=1">'
            ),
            array(  #7
                array(
                    'width'         => NULL,
                    'height'        => NULL,
                    'initial-scale' => NULL,
                    'minimum-scale' => NULL,
                    'maximum-scale' => 2,
                    'user-scalable' => NULL,
                ),
                '<meta name="viewport" content="maximum-scale=2">'
            ),
            array(  #8
                array(
                    'width'         => NULL,
                    'height'        => NULL,
                    'initial-scale' => NULL,
                    'minimum-scale' => NULL,
                    'maximum-scale' => NULL,
                    'user-scalable' => 'no',
                ),
                '<meta name="viewport" content="user-scalable=no">'
            ),
            array(  #9
                array(
                    'width'         => NULL,
                    'height'        => NULL,
                    'initial-scale' => NULL,
                    'minimum-scale' => NULL,
                    'maximum-scale' => NULL,
                    'user-scalable' => 'yes',
                ),
                '<meta name="viewport" content="user-scalable=yes">'
            ),
            array(  #10
                array(
                    'width'         => 'device-width',
                    'height'        => 'device-height',
                    'initial-scale' => NULL,
                    'minimum-scale' => NULL,
                    'maximum-scale' => NULL,
                    'user-scalable' => NULL,
                ),
                '<meta name="viewport" content="width=device-width, height=device-height">'
            ),
            array(  #11
                array(
                    'width'         => 'device-width',
                    'height'        => NULL,
                    'initial-scale' => 1,
                    'minimum-scale' => NULL,
                    'maximum-scale' => NULL,
                    'user-scalable' => NULL,
                ),
                '<meta name="viewport" content="width=device-width, initial-scale=1">'
            ),
            array(  #12
                array(
                    'width'         => 'device-width',
                    'height'        => NULL,
                    'initial-scale' => 1.5,
                    'minimum-scale' => NULL,
                    'maximum-scale' => NULL,
                    'user-scalable' => NULL,
                ),
                '<meta name="viewport" content="width=device-width, initial-scale=1.5">'
            ),
            array(  #13
                array(
                    'width'         => 'device-width',
                    'height'        => NULL,
                    'initial-scale' => 2,
                    'minimum-scale' => NULL,
                    'maximum-scale' => NULL,
                    'user-scalable' => NULL,
                ),
                '<meta name="viewport" content="width=device-width, initial-scale=2">'
            ),
            array(  #14
                array(
                    'width'         => 'device-width',
                    'height'        => NULL,
                    'initial-scale' => NULL,
                    'minimum-scale' => 1,
                    'maximum-scale' => NULL,
                    'user-scalable' => NULL,
                ),
                '<meta name="viewport" content="width=device-width, minimum-scale=1">'
            ),
            array(  #15
                array(
                    'width'         => 'device-width',
                    'height'        => NULL,
                    'initial-scale' => NULL,
                    'minimum-scale' => 2,
                    'maximum-scale' => NULL,
                    'user-scalable' => NULL,
                ),
                '<meta name="viewport" content="width=device-width, minimum-scale=2">'
            ),
            array(  #16
                array(
                    'width'         => 'device-width',
                    'height'        => NULL,
                    'initial-scale' => NULL,
                    'minimum-scale' => 1,
                    'maximum-scale' => 1,
                    'user-scalable' => NULL,
                ),
                '<meta name="viewport" content="width=device-width, minimum-scale=1, maximum-scale=1">'
            ),
            array(  #17
                array(
                    'width'         => 'device-width',
                    'height'        => NULL,
                    'initial-scale' => NULL,
                    'minimum-scale' => 1,
                    'maximum-scale' => 2,
                    'user-scalable' => NULL,
                ),
                '<meta name="viewport" content="width=device-width, minimum-scale=1, maximum-scale=2">'
            ),
            array(  #18
                array(
                    'width'         => 'device-width',
                    'height'        => NULL,
                    'initial-scale' => NULL,
                    'minimum-scale' => 1,
                    'maximum-scale' => 1,
                    'user-scalable' => 'no',
                ),
                '<meta name="viewport" content="width=device-width, minimum-scale=1, maximum-scale=1, user-scalable=no">'
            ),
            array(  #19
                array(
                    'width'         => 'device-width',
                    'height'        => NULL,
                    'initial-scale' => NULL,
                    'minimum-scale' => 1,
                    'maximum-scale' => 1,
                    'user-scalable' => 'yes',
                ),
                '<meta name="viewport" content="width=device-width, minimum-scale=1, maximum-scale=1, user-scalable=yes">'
            ),
            array(  #20
                array(
                    'width'         => 'device-width',
                    'height'        => NULL,
                    'initial-scale' => NULL,
                    'minimum-scale' => NULL,
                    'maximum-scale' => 1,
                    'user-scalable' => 'no',
                ),
                '<meta name="viewport" content="width=device-width, maximum-scale=1, user-scalable=no">'
            ),
            array(  #21
                array(
                    'width'         => 'device-width',
                    'height'        => NULL,
                    'initial-scale' => NULL,
                    'minimum-scale' => NULL,
                    'maximum-scale' => 1,
                    'user-scalable' => 'yes',
                ),
                '<meta name="viewport" content="width=device-width, maximum-scale=1, user-scalable=yes">'
            ),
            array(  #22
                array(
                    'width'         => 'device-width',
                    'height'        => NULL,
                    'initial-scale' => NULL,
                    'minimum-scale' => NULL,
                    'maximum-scale' => NULL,
                    'user-scalable' => 'no',
                ),
                '<meta name="viewport" content="width=device-width, user-scalable=no">'
            ),
            array(  #23
                array(
                    'width'         => 'device-width',
                    'height'        => NULL,
                    'initial-scale' => NULL,
                    'minimum-scale' => NULL,
                    'maximum-scale' => NULL,
                    'user-scalable' => 'yes',
                ),
                '<meta name="viewport" content="width=device-width, user-scalable=yes">'
            )
        );
    }

    /**
     * Tests Bootstrap::viewport method, which [Description]
     *
     * @dataProvider viewport_provider
     */
    public function test_viewport($options, $expected)
    {
        $this->assertEquals($expected, $this->boot->viewport($options));
    }

    /**
     * container_provider : Returns an array that contains various combinations that a user can legally
     * initiate through Bootstrap::container
     *
     * @return Array    Array of various user combinations that can be legally initiated
     */
    public function container_provider()
    {
        return array(
            array(
                'content',
                'fixed',
                '<div class="container">content</div>'
            ),
            array(
                'content',
                'fluid',
                '<div class="container-fluid">content</div>'
            ),
            array(
                'content',
                'fluid',
                '<div class="container-fluid">content</div>'
            ),
            array(
                'content',
                '',
                'error'
            ),
            array(
                'content',
                NULL,
                'error'
            )
        );
    }

    /**
     * Tests Bootstrap::container method, which [Description]
     *
     * @dataProvider container_provider
     */
    public function test_container($type, $content, $expected)
    {
        $this->assertEquals($expected, $this->boot->container($type, $content));
    }

    /**
     * row_provider : Returns an array that contains various combinations that a user can legally
     * initiate through Bootstrap::row
     *
     * @return Array    Array of various user combinations that can be legally initiated
     */
    public function row_provider()
    {
        return array(
            array(
                'content',
                '<div class="row">content</div>'
            )
        );
    }

    /**
     * Tests Bootstrap::row method, which [Description]
     *
     * @dataProvider row_provider
     */
    public function test_row($content, $expected)
    {
        $this->assertEquals($expected, $this->boot->row($content));
    }

    /**
     * column_provider : Returns an array that contains various combinations that a user can legally
     * initiate through Bootstrap::column
     *
     * @return Array    Array of various user combinations that can be legally initiated
     */
    public function column_provider()
    {
        return array(
            array(
                1,
                'xs',
                'content',
                NULL,
                '<div class="col-xs-1">content</div>'
            ),
            array(
                1,
                'sm',
                'content',
                NULL,
                '<div class="col-sm-1">content</div>'
            ),
            array(
                1,
                'md',
                'content',
                NULL,
                '<div class="col-md-1">content</div>'
            ),
            array(
                1,
                'lg',
                'content',
                NULL,
                '<div class="col-lg-1">content</div>'
            ),
            array(
                1,
                'xs',
                'content',
                NULL,
                '<div class="col-xs-1">content</div>'
            ),
            array(
                2,
                'xs',
                'content',
                NULL,
                '<div class="col-xs-2">content</div>'
            ),
            array(
                3,
                'xs',
                'content',
                NULL,
                '<div class="col-xs-3">content</div>'
            ),
            array(
                4,
                'xs',
                'content',
                NULL,
                '<div class="col-xs-4">content</div>'
            ),
            array(
                5,
                'xs',
                'content',
                NULL,
                '<div class="col-xs-5">content</div>'
            ),
            array(
                6,
                'xs',
                'content',
                NULL,
                '<div class="col-xs-6">content</div>'
            ),
            array(
                7,
                'xs',
                'content',
                NULL,
                '<div class="col-xs-7">content</div>'
            ),
            array(
                8,
                'xs',
                'content',
                NULL,
                '<div class="col-xs-8">content</div>'
            ),
            array(
                9,
                'xs',
                'content',
                NULL,
                '<div class="col-xs-9">content</div>'
            ),
            array(
                10,
                'xs',
                'content',
                NULL,
                '<div class="col-xs-10">content</div>'
            ),
            array(
                11,
                'xs',
                'content',
                NULL,
                '<div class="col-xs-11">content</div>'
            ),
            array(
                12,
                'xs',
                'content',
                NULL,
                '<div class="col-xs-12">content</div>'
            ),
            array(
                2,
                'sm',
                'content',
                NULL,
                '<div class="col-sm-2">content</div>'
            ),
            array(
                3,
                'sm',
                'content',
                NULL,
                '<div class="col-sm-3">content</div>'
            ),
            array(
                4,
                'sm',
                'content',
                NULL,
                '<div class="col-sm-4">content</div>'
            ),
            array(
                5,
                'sm',
                'content',
                NULL,
                '<div class="col-sm-5">content</div>'
            ),
            array(
                6,
                'sm',
                'content',
                NULL,
                '<div class="col-sm-6">content</div>'
            ),
            array(
                7,
                'sm',
                'content',
                NULL,
                '<div class="col-sm-7">content</div>'
            ),
            array(
                8,
                'sm',
                'content',
                NULL,
                '<div class="col-sm-8">content</div>'
            ),
            array(
                9,
                'sm',
                'content',
                NULL,
                '<div class="col-sm-9">content</div>'
            ),
            array(
                10,
                'sm',
                'content',
                NULL,
                '<div class="col-sm-10">content</div>'
            ),
            array(
                11,
                'sm',
                'content',
                NULL,
                '<div class="col-sm-11">content</div>'
            ),
            array(
                12,
                'sm',
                'content',
                NULL,
                '<div class="col-sm-12">content</div>'
            ),
            array(
                2,
                'md',
                'content',
                NULL,
                '<div class="col-md-2">content</div>'
            ),
            array(
                3,
                'md',
                'content',
                NULL,
                '<div class="col-md-3">content</div>'
            ),
            array(
                4,
                'md',
                'content',
                NULL,
                '<div class="col-md-4">content</div>'
            ),
            array(
                5,
                'md',
                'content',
                NULL,
                '<div class="col-md-5">content</div>'
            ),
            array(
                6,
                'md',
                'content',
                NULL,
                '<div class="col-md-6">content</div>'
            ),
            array(
                7,
                'md',
                'content',
                NULL,
                '<div class="col-md-7">content</div>'
            ),
            array(
                8,
                'md',
                'content',
                NULL,
                '<div class="col-md-8">content</div>'
            ),
            array(
                9,
                'md',
                'content',
                NULL,
                '<div class="col-md-9">content</div>'
            ),
            array(
                10,
                'md',
                'content',
                NULL,
                '<div class="col-md-10">content</div>'
            ),
            array(
                11,
                'md',
                'content',
                NULL,
                '<div class="col-md-11">content</div>'
            ),
            array(
                12,
                'md',
                'content',
                NULL,
                '<div class="col-md-12">content</div>'
            ),
            array(
                2,
                'lg',
                'content',
                NULL,
                '<div class="col-lg-2">content</div>'
            ),
            array(
                3,
                'lg',
                'content',
                NULL,
                '<div class="col-lg-3">content</div>'
            ),
            array(
                4,
                'lg',
                'content',
                NULL,
                '<div class="col-lg-4">content</div>'
            ),
            array(
                5,
                'lg',
                'content',
                NULL,
                '<div class="col-lg-5">content</div>'
            ),
            array(
                6,
                'lg',
                'content',
                NULL,
                '<div class="col-lg-6">content</div>'
            ),
            array(
                7,
                'lg',
                'content',
                NULL,
                '<div class="col-lg-7">content</div>'
            ),
            array(
                8,
                'lg',
                'content',
                NULL,
                '<div class="col-lg-8">content</div>'
            ),
            array(
                9,
                'lg',
                'content',
                NULL,
                '<div class="col-lg-9">content</div>'
            ),
            array(
                10,
                'lg',
                'content',
                NULL,
                '<div class="col-lg-10">content</div>'
            ),
            array(
                11,
                'lg',
                'content',
                NULL,
                '<div class="col-lg-11">content</div>'
            ),
            array(
                12,
                'lg',
                'content',
                NULL,
                '<div class="col-lg-12">content</div>'
            ),
            array(
                1,
                'xs',
                'content',
                '.control-group',
                '<div class="col-xs-1 control-group">content</div>'
            ),
            array(
                1,
                'xs',
                'content',
                array(
                    '.control-group',
                    '.second'
                ),
                '<div class="col-xs-1 control-group second">content</div>'
            )
        );
    }

    /**
     * Tests Bootstrap::column method, which [Description]
     *
     * @dataProvider column_provider
     */
    public function test_column($amount, $size, $content, $alt, $expected)
    {
        $this->assertEquals($expected, $this->boot->column($amount, $size, $content, $alt));
    }

    /**
     * panel_provider : Returns an array that contains various combinations that a user can legally
     * initiate through Bootstrap::panel
     *
     * @return Array    Array of various user combinations that can be legally initiated
     */
    public function panel_provider()
    {
        return array(
            array(
                'header',
                'Header of Panel',
                'Body of Panel',
                NULL,
                '<div class="panel panel-default"><div class="panel-heading">Header of Panel</div><div class="panel-body">Body of Panel</div></div>'
            ),
            array(
                'header',
                'Header of Panel',
                'Body of Panel',
                '.form-group',
                '<div class="panel panel-default"><div class="panel-heading">Header of Panel</div><div class="panel-body form-group">Body of Panel</div></div>'
            ),
            array(
                'footer',
                'Footer of Panel',
                'Body of Panel',
                NULL,
                '<div class="panel panel-default"><div class="panel-body">Body of Panel</div><div class="panel-footer">Footer of Panel</div></div>'
            ),
            array(
                'footer',
                'Footer of Panel',
                'Body of Panel',
                array(
                    '.form-group',
                    '.control'
                ),
                '<div class="panel panel-default"><div class="panel-body form-group control">Body of Panel</div><div class="panel-footer">Footer of Panel</div></div>'
            ),
            array(
                'foote',
                'Footer of Panel',
                'Body of Panel',
                NULL,
                'error'
            )
        );
    }

    /**
     * Tests Bootstrap::panel method, which [Description]
     *
     * @dataProvider panel_provider
     */
    public function test_panel($type, $caption, $body, $alt, $expected)
    {
        $this->assertEquals($expected, $this->boot->panel($type, $caption, $body, $alt));
    }
}
?>