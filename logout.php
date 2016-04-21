<?php
/**
 * Logout Page
 *
 * @package     WSC\Logout
 * @category    Logout
 * @author      Justin D. Byrne <justin@byrne-systems.com>
 */

require '/lib/wsc_Framework/template.class.php';

use WSC\Framework\Engines\Template;                     # Template: engine developed to substitute special WSC tags while publishing a clean HTML document

# Set: Root Directory
$root = rtrim(dirname(__FILE__), '/lib');

# Load: LESS Plugin
require_once 'inc/less.php-plugin.php';                 # Initiates: less.php plugin to parse LESS syntax to CSS

session_start();

# Load: ancillary (or contributory) views
$notes  = new Template($root . '/web/views/' . 'notes.wad');
$meta   = new Template($root . '/web/views/' . 'meta.wad');
$styles = new Template($root . '/web/views/' . 'style-sheets.wad');
$script = new Template($root . '/web/views/' . 'script.wad');

# Load: layout 'bootstrap'
$layout = new Template($root . '/web/views/layouts/'  . 'bootstrap.logout.wad');

# Load: logout page(s)
$logout = new Template($root . '/web/views/' . 'logout.wad');

# Get: logout page(s) message tag from URL; if available
$logout_message = (!empty($_GET['err'])) ? $_GET['err'] : 'You\'ve been logged out of the Williams Specialty Company - Business Automation Application; and you should be redirected shortly!';

# Set: logout page(s) message tag
$logout->set('message',                 $logout_message);

# Set: tags inside layout 'bootstrap'
$layout->set('file_notes',              $notes->output());
$layout->set('title',                   'WSC - Logout');
$layout->set('meta_tags',               $meta->output());
$layout->set('favicon',                 '<link href="data:image/x-icon;base64,AAABAAEAEBAAAAEAIABoBAAAFgAAACgAAAAQAAAAIAAAAAEAIAAAAAAAAAQAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAALKNTLyyjUyFWUcmIAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAEs9DBlLPQwZSz0MGQAAAAAzJwkZMycJDLKNTDCyjUz/so1M/7KNTJgTDwgCMycJGTMnCRlLPQwZSz0MGUs9DBnAmx5uwJse/8CbHv/Amx7agWQY0oFkGPmaeTIxso1M07KNTMyyjUxTgWQYn4FkGPC1kR2dwJse/8CbHv/Amx7bAAAAAMCbHuPAmx7/wJse/7CNHY+BZBj/gWQY0y0jEwRZRyZfYUsSa4FkGP+ObxmDwJse98CbHv/Amx7/YE4PZwAAAAA+MgokwJse/8CbHv/Amx7/m3sabYFkGP9YRBCBQTIMLIFkGPeBZBjcwJsev8CbHv/Amx7/wJserAAAAAAAAAAAAAAAAMCbHm7Amx7/wJse/8CbHtOBZBi4gWQY/4FkGM+BZBj2p4UclMCbHv/Amx7/wJse5ks9DAwAAAAAAAAAAAAAAAAAAAAAwJsezsCbHv/Amx7/rIoclIFkGPeBZBj/mnoamcCbHv/Amx7/wJse/mBOD1cAAAAAAAAAAAAAAAAAAAAAAAAAAGdTECDAmx7/wJse/8CbHv+efhuOgWQYx8CbHsbAmx7/wJse/8CbHp8AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAdV4Sd8CbHv/Amx7/wJse5b+aHm7Amx7/wJse/8CbHucAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAADAmx7RwJse/8CbHv/Amx78wJse/8CbHv+CaRRAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAYE4PD8CbHvvAmx7/wJse/8CbHv/Amx6LAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAACefxlxwJse/8CbHv/Amx7XAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAMCbHuTAmx7/q4obJQAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAABgTg8HuZUdkgAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA//8AAP5/AAD+PwAAgkAAAIHBAADEgQAA4AMAAOAHAADwBwAA+I8AAPgfAAD8HwAA/j8AAP5/AAD/fwAA//8AAA==" rel="icon" type="image/x-icon" />');
$layout->set('styles',                  $styles->output());
$layout->set('wrapper',                 'williams');
$layout->set('main_container',          'container');
$layout->set('main',                    $logout->output());
$layout->set('script',                  $script->output());

# Load: all compiled views and consoles into 'app.wad' to echo to users' stdout
$app = new Template($root . '/web/views/' . 'app.wad');
$app->set('app',                            $layout->output());

# Destroy: session along with all session data; and/or variables
session_destroy();

header('refresh:5;url=http://localhost');

# Parse: logout screen
echo $app->output();

// var_dump($_SESSION);     [TEMP]