<?php
/**
 * @uses            less.php 1.7.0.9
 * @author          Matt Agar           <https://github.com/agar>
 * @updated         Martin Jantosovic   <https://github.com/Mordred>
 * @link            https://github.com/oyejorge/less.php
 */

// Load: LESS.php
require '/lib/less.php/lib/Less/Autoloader.php';

Less_Autoloader::register();

// LESS.PHP Options
$options = array(
    // 'cache_dir'         => $local . '/web/styles/css/',
    // 'compress'          => true,
    'sourceMap'         => true,
    'sourceMapWriteTo'  => '/data/logs/LESS_source.map',
    'sourceMapURL'      => '/data/logs/LESS_source.map',
    );

// Parse: LESS to CSS
try {
    $parser = new Less_Parser($options);
    $parser->parseFile('/web/styles/less/styles.less', '/', 'http://www.byrne-systems.com');
    $css = $parser->getCss();
} catch (Exception $e) {
    $error_msg = $e->getMessage();
}
?>