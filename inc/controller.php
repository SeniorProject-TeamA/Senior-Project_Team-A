<?php
/**
 * WSC DESCRIPTION!
 *
 * @package     Controller
 * @category    Controllers
 * @author      Justin D. Byrne <justinbyrne001@gmail.com>
 */

namespace WSC\Controller;

require '/../lib/wsc_Framework/session-manager.class.php';
require '/../lib/wsc_Framework/template.class.php';
require '/../lib/wsc_Framework/dba.class.php';

use WSC\Controller;
use WSC\Framework\Controls\SessionManager;              # Session: manager to instantiate and control session data
use WSC\Framework\Engines\Template;                     # Template: engine developed to substitute special WSC tags while publishing a clean HTML document

# Set: Root Directory
$root = rtrim(dirname(__FILE__), '/inc');

# Load: LESS Plugin
require_once 'less.php-plugin.php';                     # Initiates: less.php plugin to parse LESS syntax to CSS

$SM = new SessionManager;

session_start();
$SM->session_timeout();

# Load: ancillary (or contributory) views
$notes  = new Template($root . '/web/views/' . 'notes.wad');
$meta   = new Template($root . '/web/views/' . 'meta.wad');
$styles = new Template($root . '/web/views/' . 'style-sheets.wad');
$script = new Template($root . '/web/views/' . 'script.wad');

# Verify: session state
if (empty($_SESSION['login_string']) || empty($_SESSION['emp_id'])) {

    # --------------------------------- [ Login Screen ] ---------------------------------

    # Load: layout 'bootstrap'
    $layout = new Template($root . '/web/views/layouts/'  . 'bootstrap.login.wad');

    # Load: login console(s)
    $login = new Template($root . '/web/views/consoles/' . 'login.wad');

    # Set: tags inside layout 'bootstrap'
    $layout->set('file_notes',              $notes->output());
    $layout->set('title',                   'Williams Specialty Company (WSC) - Business Process Automation (BPA) Application System');
    $layout->set('meta_tags',               $meta->output());
    $layout->set('favicon',                 '<link href="data:image/x-icon;base64,AAABAAEAEBAAAAEAIABoBAAAFgAAACgAAAAQAAAAIAAAAAEAIAAAAAAAAAQAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAALKNTLyyjUyFWUcmIAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAEs9DBlLPQwZSz0MGQAAAAAzJwkZMycJDLKNTDCyjUz/so1M/7KNTJgTDwgCMycJGTMnCRlLPQwZSz0MGUs9DBnAmx5uwJse/8CbHv/Amx7agWQY0oFkGPmaeTIxso1M07KNTMyyjUxTgWQYn4FkGPC1kR2dwJse/8CbHv/Amx7bAAAAAMCbHuPAmx7/wJse/7CNHY+BZBj/gWQY0y0jEwRZRyZfYUsSa4FkGP+ObxmDwJse98CbHv/Amx7/YE4PZwAAAAA+MgokwJse/8CbHv/Amx7/m3sabYFkGP9YRBCBQTIMLIFkGPeBZBjcwJsev8CbHv/Amx7/wJserAAAAAAAAAAAAAAAAMCbHm7Amx7/wJse/8CbHtOBZBi4gWQY/4FkGM+BZBj2p4UclMCbHv/Amx7/wJse5ks9DAwAAAAAAAAAAAAAAAAAAAAAwJsezsCbHv/Amx7/rIoclIFkGPeBZBj/mnoamcCbHv/Amx7/wJse/mBOD1cAAAAAAAAAAAAAAAAAAAAAAAAAAGdTECDAmx7/wJse/8CbHv+efhuOgWQYx8CbHsbAmx7/wJse/8CbHp8AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAdV4Sd8CbHv/Amx7/wJse5b+aHm7Amx7/wJse/8CbHucAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAADAmx7RwJse/8CbHv/Amx78wJse/8CbHv+CaRRAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAYE4PD8CbHvvAmx7/wJse/8CbHv/Amx6LAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAACefxlxwJse/8CbHv/Amx7XAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAMCbHuTAmx7/q4obJQAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAABgTg8HuZUdkgAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA//8AAP5/AAD+PwAAgkAAAIHBAADEgQAA4AMAAOAHAADwBwAA+I8AAPgfAAD8HwAA/j8AAP5/AAD/fwAA//8AAA==" rel="icon" type="image/x-icon" />');
    $layout->set('styles',                  $styles->output());
    $layout->set('wrapper',                 'williams');
    $layout->set('logo_container',          'container');
    $layout->set('logo',                    $layout->div($layout->tag('<img class="img-responsive" src="../web/images/wsc_logo_full.png">', 'figure', '#wsc-logo'), '.row'));
    $layout->set('main_container',          'container');
    $layout->set('main',                    $login->output());
    $layout->set('script',                  $script->output());

} else {

    # --------------------------------- [ Master Admin ] ---------------------------------

    #####################################################
    #                  Load Template(s)                 #
    #####################################################

    # Load: layout 'bootstrap'
    $layout     = new Template($root . '/web/views/layouts/'  . 'bootstrap.wad');

    # Load: primary page elements
    $header     = new Template($root . '/web/views/' . 'header.wad');
    $main       = new Template($root . '/web/views/' . 'main.wad');
    $footer     = new Template($root . '/web/views/' . 'footer.wad');

    # Load: login console(s)
    $admin      = new Template($root . '/web/views/consoles/' . 'admin.wad');
    $customer   = new Template($root . '/web/views/consoles/' . 'customer.wad');
    $work_order = new Template($root . '/web/views/consoles/' . 'work-order.wad');
    $shipping   = new Template($root . '/web/views/consoles/' . 'shipping.wad');
    $billing    = new Template($root . '/web/views/consoles/' . 'billing.wad');
    $qa         = new Template($root . '/web/views/consoles/' . 'qa.wad');
    $notify     = new Template($root . '/web/views/consoles/' . 'notify.wad');
    $search     = new Template($root . '/web/views/consoles/' . 'search.wad');

    #####################################################
    ###               Set Header Tag(s)               ###
    ######################################################

    # Set: header tag(s)
    $header->set('logout_link',             'logout.php');

    #####################################################
    #           Load Input into Console(s)              #
    #####################################################

    # Set: console tag(s) inside this console view
    $admin->set('emp_id',                   (isset($_SESSION['emp_id']))        ? $_SESSION['emp_id']        : '');
    $admin->set('emp_name',                 (isset($_SESSION['emp_name']))      ? $_SESSION['emp_name']      : '');
    $admin->set('emp_title',                (isset($_SESSION['emp_title']))     ? $_SESSION['emp_title']     : '');

    # Check: $_SESSION variables for '$customer' console
    $customer->set('customer_name',         (isset($_SESSION['customer_name'])) ? $_SESSION['customer_name'] : '');
    $customer->set('phone',                 (isset($_SESSION['phone']))         ? $_SESSION['phone']         : '');
    $customer->set('email',                 (isset($_SESSION['email']))         ? $_SESSION['email']         : '');

    # Check: $_SESSION variable for '$work_order' console
    $work_order->set('work-order-id',       (isset($_SESSION['work-order-id'])) ? $_SESSION['work-order-id'] : '');
    $work_order->set('job-type',            (isset($_SESSION['job-type']))      ? '<option value="' . $_SESSION['job-type']     . '" selected>' . $_SESSION['job-type']     . '</option>' : '');
    $work_order->set('media-type',          (isset($_SESSION['media-type']))    ? '<option value="' . $_SESSION['media-type']   . '" selected>' . $_SESSION['media-type']   . '</option>' : '');
    $work_order->set('payment-type',        (isset($_SESSION['payment-type']))  ? '<option value="' . $_SESSION['payment-type'] . '" selected>' . $_SESSION['payment-type'] . '</option>' : '');
    $work_order->set('order-details',       (isset($_SESSION['order-details'])) ? $_SESSION['order-details'] : '');

    # Check: $_SESSION variable for '$shipping' console
    $shipping->set('ship-address',          (isset($_SESSION['ship-address']))  ? $_SESSION['ship-address']  : '');
    $shipping->set('ship-city',             (isset($_SESSION['ship-city']))     ? $_SESSION['ship-city']     : '');
    $shipping->set('ship-state',            (isset($_SESSION['ship-state']))    ? '<option value="' . $_SESSION['ship-state'] . '" selected>' . $_SESSION['ship-state'] . '</option>' : '');
    $shipping->set('ship-zip',              (isset($_SESSION['ship-zip']))      ? $_SESSION['ship-zip']      : '');

    # Check: $_SESSION variable for '$billing' console
    $billing->set('bill-address',           (isset($_SESSION['bill-address']))  ? $_SESSION['bill-address']  : '');
    $billing->set('bill-city',              (isset($_SESSION['bill-city']))     ? $_SESSION['bill-city']     : '');
    $billing->set('bill-state',             (isset($_SESSION['bill-state']))    ? '<option value="' . $_SESSION['bill-state'] . '" selected>' . $_SESSION['bill-state'] . '</option>' : '');
    $billing->set('bill-zip',               (isset($_SESSION['bill-zip']))      ? $_SESSION['bill-zip']      : '');
    $billing->set('copy-shipping',          (isset($_SESSION['copy-shipping'])) ? 'checked'                  : '');

    # Check: $_SESSION variable for '$qa' console
    $qa->set('qa-scratch',                  (isset($_SESSION['qa-scratch']))       ? 'checked'  : '');
    $qa->set('qa-dent',                     (isset($_SESSION['qa-dent']))          ? 'checked'  : '');
    $qa->set('qa-break',                    (isset($_SESSION['qa-break']))         ? 'checked'  : '');
    $qa->set('qa-misspelling',              (isset($_SESSION['qa-misspelling']))   ? 'checked'  : '');
    $qa->set('qa-smudge',                   (isset($_SESSION['qa-smudge']))        ? 'checked'  : '');
    $qa->set('qa-tear',                     (isset($_SESSION['qa-tear']))          ? 'checked'  : '');
    $qa->set('qa-discoloration',            (isset($_SESSION['qa-discoloration'])) ? 'checked'  : '');

    # Check: $_SESSION variable for '$notify' (or Notification) console
    $notify->set('notify-type',             (isset($_SESSION['notify-type']))   ? '<option value="' . $_SESSION['notify-type'] . '" selected>' . $_SESSION['notify-type'] . '</option>' : '');
    $notify->set('notify-memo',             (isset($_SESSION['notify-memo']))   ? $_SESSION['notify-memo']   : '');

    # Check: $_SESSION variable for '$search' (or Inventory Management) console
    $search->set('search-type',             (isset($_SESSION['search-type']))   ? '<option value="' . $_SESSION['search-type'] . '" selected>' . $_SESSION['search-type'] . '</option>' : '');
    $search->set('inv-search',              (isset($_SESSION['inv-search']))    ? $_SESSION['inv-search']    : '');

    #####################################################
    #            Inject Panel(s) into Main              #
    #####################################################

    # Set: console tags inside of the main view
    $main->set('admin_panel',               $admin->output());
    $main->set('customer',                  $customer->output());
    $main->set('work_order',                $work_order->output());
    $main->set('shipping',                  $shipping->output());
    $main->set('billing',                   $billing->output());
    $main->set('qa',                        $qa->output());
    $main->set('notification',              $notify->output());
    $main->set('search',                    $search->output());

    # Set: session return for admin return notification(s)
    $main->set('session-return',            (isset($_SESSION['init_result']))  ? $_SESSION['init_result']  : '');

    #####################################################
    #                 Build Admin Page                  #
    #####################################################

    # Set: tags inside layout 'bootstrap'
    $layout->set('file_notes',              $notes->output());
    $layout->set('title',                   'Williams Specialty Company (WSC) - Business Process Automation (BPA) Application System');
    $layout->set('meta_tags',               $meta->output());
    $layout->set('favicon',                 '<link href="data:image/x-icon;base64,AAABAAEAEBAAAAEAIABoBAAAFgAAACgAAAAQAAAAIAAAAAEAIAAAAAAAAAQAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAALKNTLyyjUyFWUcmIAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAEs9DBlLPQwZSz0MGQAAAAAzJwkZMycJDLKNTDCyjUz/so1M/7KNTJgTDwgCMycJGTMnCRlLPQwZSz0MGUs9DBnAmx5uwJse/8CbHv/Amx7agWQY0oFkGPmaeTIxso1M07KNTMyyjUxTgWQYn4FkGPC1kR2dwJse/8CbHv/Amx7bAAAAAMCbHuPAmx7/wJse/7CNHY+BZBj/gWQY0y0jEwRZRyZfYUsSa4FkGP+ObxmDwJse98CbHv/Amx7/YE4PZwAAAAA+MgokwJse/8CbHv/Amx7/m3sabYFkGP9YRBCBQTIMLIFkGPeBZBjcwJsev8CbHv/Amx7/wJserAAAAAAAAAAAAAAAAMCbHm7Amx7/wJse/8CbHtOBZBi4gWQY/4FkGM+BZBj2p4UclMCbHv/Amx7/wJse5ks9DAwAAAAAAAAAAAAAAAAAAAAAwJsezsCbHv/Amx7/rIoclIFkGPeBZBj/mnoamcCbHv/Amx7/wJse/mBOD1cAAAAAAAAAAAAAAAAAAAAAAAAAAGdTECDAmx7/wJse/8CbHv+efhuOgWQYx8CbHsbAmx7/wJse/8CbHp8AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAdV4Sd8CbHv/Amx7/wJse5b+aHm7Amx7/wJse/8CbHucAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAADAmx7RwJse/8CbHv/Amx78wJse/8CbHv+CaRRAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAYE4PD8CbHvvAmx7/wJse/8CbHv/Amx6LAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAACefxlxwJse/8CbHv/Amx7XAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAMCbHuTAmx7/q4obJQAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAABgTg8HuZUdkgAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA//8AAP5/AAD+PwAAgkAAAIHBAADEgQAA4AMAAOAHAADwBwAA+I8AAPgfAAD8HwAA/j8AAP5/AAD/fwAA//8AAA==" rel="icon" type="image/x-icon" />');
    $layout->set('styles',                  $styles->output());
    $layout->set('wrapper',                 'williams');

    $layout->set('header',                  $header->output());
    $layout->set('main',                    $main->output());
    $layout->set('footer',                  $footer->output());

    $layout->set('script',                  $script->output());
}

# Load: all compiled views and consoles into 'app.wad' to echo to users' stdout
$app = new Template($root . '/web/views/' . 'app.wad');
$app->set('app',                            $layout->output());