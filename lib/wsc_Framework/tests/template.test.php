<?php
/**
 * testTemplate : Unit Testing class for "template.class.php"
 *
 * @package     Template Engine\testTemplate
 * @category    UnitTest
 * @author      Justin D. Byrne <justinbyrne001@gmail.com>
 */

namespace WSC\UnitTests;

use WSC\UnitTests\testTemplate;
use WSC\Framework\Engines\Template;

require_once __DIR__ . '/../template.class.php';

/**
 * @author  Justin D. Byrne <justin@byrne-systems.com>
 */
class testTemplate extends \phpUnit_Framework_TestCase {
    protected $template;

    public function setUp()
    {
        $assets = 'C:/xampp/htdocs/lib/stg_Framework/tests/assets/';                                # Location: of vital assets for unit testing
        $this->template = new Template($assets . 'testTemplate.wad');                               # Instantiate: new Template object
    }

    /**
     * [Description]
     *
     * @assert()                                        [Description]
     */
    public function test_template_set_N_output_methods()
    {
        $this->template->set('test', 'Application Test');                                           # Set: tag 'test' to 'Application Test'
        $this->assertEquals('Application Test', $this->template->output());                         # @assertEquals
    }

    /**
     * [Description]
     */
    public function test_Merge_Templates()
    {
        $assets = 'C:/xampp/htdocs/lib/stg_Framework/tests/assets/';                                # Location: of vital assets for unit testing

        // Generate: an array holding various user's attributes
        $users = array(
            array(      # [0] CASE: First user and their associated birthplace
                "username" => "monkey",
                "location" => "Portugal"
            ),
            array(      # [1] CASE: Second user and their associated birthplace
                "username" => "Sailor",
                "location" => "Moon"
            ),
            array(      # [2] CASE: Third user and their associated birthplace
                "username" => "Trex",
                "location" => "Caribbean Islands"
            )
        );

        // Set: each user's value within '$users' (Array) into '$row' then put all rows in '$users_templates'
        foreach ($users as $user) {
            $row = new Template($assets . 'list_users_row.wad');

            foreach ($user as $key => $value) { $row->set($key, $value); }

            $users_templates[] = $row;
        }

        $users_contents = Template::merge($users_templates);                                        # Merge: template's together

        $users_list = new Template($assets . 'list_users.wad');                                     # Instantiate: new template

        $users_list->set('users', $users_contents);                                                 # Set: the '$user_contents' within the '$users_list' (Object)

        $layout = new Template($assets . 'layout.wad');                                             # Instantiate: new template

        $layout->set('title', 'Users');                                                             # Set: the 'title' of the '$layout' template with "Users"

        $layout->set('content', $users_list->output());                                             # Set: the 'content' of the '$users_list' template with the parsed content of '$users_list'

        $expected = file_get_contents($assets . 'page.html');                                       # Get: expected file contents of the 'page.html' file

        // Assert: both $expected and asserted context(s) with preg_split, to negate any addition (or added) carriage returns...
        $this->assertEquals(preg_split('/\r\n|\r|\n/',$expected), preg_split('/\r\n|\r|\n/', $layout->output()));
    }

    /**
     * [Description]
     *
     * @assert()                                        [Description]
     */
    public function test_Failure_Output()
    {
        $this->template = new Template('not_real_file.wad');                                        # Instantiate: new template with a phony template file

        $msg = 'Error loading template file (not_real_file.wad).';                                  # Error message

        $this->assertEquals($msg, $this->template->output());                                       # Output: parsed content
    }
}