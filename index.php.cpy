<?php
/**
 * WSC DESCRIPTION!
 *
 * @package     WSC
 * @author      Justin Don Byrne <justinbyrne001@gmail.com>
 * @coauthor    James Coltman <email@address.com>
 * @version     0.1 [In development]
 * @copyright   2016
 */

    // ---------------\/- [ TEMP ] -\/------------------

    require_once 'less.php-plugin.php';                      // Initiates: less.php plugin to parse LESS syntax to CSS
    require_once 'js-array.php';                             // Array: with JavaScript asset paths stored inside

    // ---------------/\- [ TEMP ] -/\------------------

    require '/lib/wsc_Framework/template.class.php';
    // require '/lib/wsc_Framework/dba.class.php';

    use WSC\Framework\Engines\Template;                 // Template: engine developed to substitute special WSC tags while publishing a clean HTML document
    // use WSC\Framework\Adapters\DBA;

// -------------------------------------------------------------------------------------------------

    ////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////  Controller  //////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////

// -------------------------------------------------------------------------------------------------

    // Set: Views Directory
    $views_dir = $_SERVER['DOCUMENT_ROOT'] . '/web/views/';

    // Template Views
    $layout     = new Template($views_dir . 'layout.html5.wad');
    $notes      = new Template($views_dir . 'notes.wad');
    $meta       = new Template($views_dir . 'meta.wad');
    $header     = new Template($views_dir . 'header.wad');
    $main       = new Template($views_dir . 'main.wad');
    $login      = new Template($views_dir . 'login.wad');
    $script     = new Template($views_dir . 'script.wad');
    $app        = new Template($views_dir . 'app.wad');

    // Template Consoles
    $admin      = new Template($views_dir . 'consoles/' . 'admin.wad');
    $work_order = new Template($views_dir . 'consoles/' . 'work-order.wad');
    $shipping   = new Template($views_dir . 'consoles/' . 'shipping.wad');
    $billing    = new Template($views_dir . 'consoles/' . 'billing.wad');
    $notify     = new Template($views_dir . 'consoles/' . 'notify.wad');

// -------------------------------------------------------------------------------------------------

    /**
     * Set: Tags & Content
     */

    // Set consoles for main page; or administration panel
    $main->set('admin_panel',               $admin->output());
    $main->set('work_order',                $work_order->output());
    $main->set('shipping',                  $shipping->output());
    $main->set('billing',                   $billing->output());
    $main->set('notification',              $notify->output());

    // Set Application's Layout
    $layout->set('file_notes',              $notes->output());
    $layout->set('title',                   'Williams Specialty Company (WSC) - Business Process Automation (BPA) Application System');
    $layout->set('meta_tags',               $meta->output());
    $layout->set('styles',                  '<link rel="stylesheet" type="text/css" href="/web/styles/css/style.css">');
    $layout->set('header',                  $header->output());
    $layout->set('script',                  $script->output());
    // $layout->set('main',                    $login->output());
    $layout->set('main',                    $main->output());
    $layout->set('favicon',                 '<link href="data:image/x-icon;base64,AAABAAEAEBAAAAEAIABoBAAAFgAAACgAAAAQAAAAIAAAAAEAIAAAAAAAAAQAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAALKNTLyyjUyFWUcmIAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAEs9DBlLPQwZSz0MGQAAAAAzJwkZMycJDLKNTDCyjUz/so1M/7KNTJgTDwgCMycJGTMnCRlLPQwZSz0MGUs9DBnAmx5uwJse/8CbHv/Amx7agWQY0oFkGPmaeTIxso1M07KNTMyyjUxTgWQYn4FkGPC1kR2dwJse/8CbHv/Amx7bAAAAAMCbHuPAmx7/wJse/7CNHY+BZBj/gWQY0y0jEwRZRyZfYUsSa4FkGP+ObxmDwJse98CbHv/Amx7/YE4PZwAAAAA+MgokwJse/8CbHv/Amx7/m3sabYFkGP9YRBCBQTIMLIFkGPeBZBjcwJsev8CbHv/Amx7/wJserAAAAAAAAAAAAAAAAMCbHm7Amx7/wJse/8CbHtOBZBi4gWQY/4FkGM+BZBj2p4UclMCbHv/Amx7/wJse5ks9DAwAAAAAAAAAAAAAAAAAAAAAwJsezsCbHv/Amx7/rIoclIFkGPeBZBj/mnoamcCbHv/Amx7/wJse/mBOD1cAAAAAAAAAAAAAAAAAAAAAAAAAAGdTECDAmx7/wJse/8CbHv+efhuOgWQYx8CbHsbAmx7/wJse/8CbHp8AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAdV4Sd8CbHv/Amx7/wJse5b+aHm7Amx7/wJse/8CbHucAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAADAmx7RwJse/8CbHv/Amx78wJse/8CbHv+CaRRAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAYE4PD8CbHvvAmx7/wJse/8CbHv/Amx6LAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAACefxlxwJse/8CbHv/Amx7XAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAMCbHuTAmx7/q4obJQAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAABgTg8HuZUdkgAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA//8AAP5/AAD+PwAAgkAAAIHBAADEgQAA4AMAAOAHAADwBwAA+I8AAPgfAAD8HwAA/j8AAP5/AAD/fwAA//8AAA==" rel="icon" type="image/x-icon" />');
    $layout->set('wrapper',                 'williams');

    $app->set('app', $layout->output());

// -----------------------------------------------------------------------------------------------------

    echo $app->output();

    // $dba = new DBA;

    // $result = $dba->query("SELECT `LastName` FROM `customer` WHERE `FirstName` = \"Mary\";");

    // var_dump($result);
    // print_r($result);

    // foreach ($result as $key => $value) {
        // echo 'Key: ' . $key . '<br>';

        // foreach ($value as $v) {
            // echo 'Value: ' . $v . '<br>';
        // }
    // }

    // printf($result);
    // echo($result);