<?php
/**
 * @uses            less.php 1.7.0.9
 * @author          Matt Agar           <https://github.com/agar>
 * @updated         Martin Jantosovic   <https://github.com/Mordred>
 * @link            https://github.com/oyejorge/less.php
 */

// Load: LESS.php
require_once '/lib/less.php/lib/Less/Autoloader.php';

Less_Autoloader::register();

// LESS.PHP Options
$options = array(
    // 'cache_dir'         => __DIR__ . '/web/styles/css/',
    // 'compress'          => true,
    'sourceMap'         => true,
    'sourceMapWriteTo'  => __DIR__ . '/data/logs/LESS_source.map',
    'sourceMapURL'      => __DIR__ . '/data/logs/LESS_source.map',
    );

// Parse: LESS to CSS
try {
    $parser = new Less_Parser($options);
    $parser->parseFile(__DIR__ . '/web/styles/less/styles.less', '/wsc/');
    $css = $parser->getCss();

    // Validate: whether CSS was parsed and $css contains data
    if (!isset($css)) {
        echo "[ERROR] No CSS was parsed from plugin: less.php" . '<br>';
        $imported_files = $parser->allParsedFiles();
        var_dump($imported_files);
    } else {
        $file = fopen(__DIR__ . "/web/styles/css/style.css", 'w') or die("Unable to open file!");
        fwrite($file, $css);
        fclose($file);
    }
} catch (Exception $e) {
    echo $e->getMessage();
}
?>