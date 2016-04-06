<?php
/**
 * testDBA : Unit Testing class for "DBA.class.php"
 *
 * @package      DBA\testDBA
 * @category     UnitTest
 * @author       James Coltman
 */

namespace WSC\UnitTests;

use WSC\UnitTests\testDBA;
use WSC\Framework\Adapters\DBA;

require_once __DIR__ . '/../DBA.class.php';

/**
 * @author  James Coltman
 */
class testDBA extends \PHPUnit_Framework_TestCase {
    protected $dba;

    /**
     * setUp : Instantiate '$dba' object to run subsequently recurring tests
     */
    public function setUp()
    {
        $this->dba = new DBA;                           // Instantiate: new dba object to run a series of unit-tests
    }

    /**
     * query_provider : Returns an array that contains various combinations that a user can legally
     * initiate through DBA::query
     *
     * @return Array    Array of various user combinations that can be legally initiated
     */
    public function query_provider()
    {
        return array(
            array(
                '"SELECT `LastName` FROM `customer` WHERE `FirstName` = \"Mary\";"',
                'Mary'
            )
        );
    }

    /**
     * Tests DBA::query method, which [Description]
     *
     * @dataProvider query_provider
     */
    public function test_query($statment, $expected)
    {
        $this->assertEquals($expected, $this->dba->query($statement));
    }
}
?>