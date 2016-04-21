<?php
/**
 * @uses            less.php 1.7.0.9
 * @author          Matt Agar           <https://github.com/agar>
 * @updated         Martin Jantosovic   <https://github.com/Mordred>
 * @link            https://github.com/oyejorge/less.php
 */

require_once '/../lib/less.php/lib/Less/Autoloader.php';# Load: LESS.php

Less_Autoloader::register();

# Parse: LESS to CSS
try {
    $parser = new Less_Parser();
    $parser->parseFile($root. '/web/styles/less/styles.less', 'http://www.byrne-systems.com/wsc/');
    $css = $parser->getCss();

    # Validate: whether CSS was parsed and $css contains data
    if (!isset($css)) {
        echo "[ERROR] No CSS was parsed from plugin: less.php" . '<br>';
        $imported_files = $parser->allParsedFiles();
        var_dump($imported_files);
    } else {
        $file = fopen($root . "/web/styles/css/style.css", 'w') or die("Unable to open file!");
        fwrite($file, $css);
        fclose($file);
    }
} catch (Exception $e) {
    echo $e->getMessage();
}
?>