<?php
/**
* This class will handle customer processes
*
* @package      Customer
* @category     Agent
* @author       James R. Coltman <iamthecoltman@gmail.com>
*/

namespace WSC\Framework\Agents;

use WSC\Framework\Agents\Customer;

class Customer {
    protected $firstName;
    protected $lastName;
    protected $address;
    protected $phone;
    protected $email;
    protected $db;

    protected $cust;

    public function __construct() {
        $this->cust = array("");
    }

    public function set_customer($array) {
        $result;

        // INSERT INTO table_name (column1,column2,column3,...)
        // VALUES (value1,value2,value3,...);
        $address = array(
            "54321 Street",
            "New York City",
            "New York",
            "12345"
        );

            $address_parts;

            foreach ($address as $part) {
                $address_parts .= $part . ",";
            }

            $stmt = "INSERT INTO " .
                    "customer (FirstName, LastName, Address, City, State, Zip, Phone, Email)" .
                    "VALUES ($firstName , $lastName, " . $address_parts . "$phone, $email";



        return $result;

    }

}
?>