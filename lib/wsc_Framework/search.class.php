<?php

/**
* This class is used for searching the database
*
* @package      search
* @category     Agent
* @author       James R. Coltman <iamthecoltman@gmail.com>
*/
namespace WSC\Framework\Agents;

require_once("dba.class.php");

use WSC\Framework\Adapters\DBA;
use WSC\Framework\Agents\search;

/**
 * [description]
 *
 * [Detailed Description]
 */
class Search {
/**
 * [__construct description]
 */
    public function __construct() {
        echo "Class: (" . __CLASS__ . ") Instantiated!". '<br>' . PHP_EOL;
    }

    public function query_Employees($search, $where) {
        $statement = "SELECT empID, Title, FirstName, LastName, Address, City, State, Zip, Phone, Email FROM `employee` ";
        $db = new DBA;
        $query;
        switch ($where) {
            case "empID": $statement.= "WHERE `empID` =\"" . $search. "\" ;";
                break;
            case "Title": $statement.= "WHERE `Title` =\"" . $search. "\" ;";
                break;
            case "FirstName": $statement.= "WHERE `FirstName` =\"" . $search. "\" ;";
                break;
            case "LastName": $statement.= "WHERE `LastName` =\"" . $search. "\" ;";
                break;
            default: $statement.= ";";
        }
        //echo $statement; for verifying
        $query = $db->query($statement);
        return $query;
    }

    public function query_Customers($search, $where) {
        $statement = "SELECT cusID, FirstName, LastName, Address, City, State, Zip, Phone, Email FROM `customer` ";
        $db = new DBA;
        $query;
        switch ($where) {

            case "cusID": $statement.= "WHERE `cusID` =\"" . $search. "\" AND `ActiveIND`=1 ;";
                break;
            case "FirstName": $statement.= "WHERE `FirstName` =\"" . $search. "\" AND `ActiveIND`=1 ;";
                break;
            case "LastName": $statement.= "WHERE `LastName` =\"" . $search. "\" AND `ActiveIND`=1 ;";
                break;
            default: $statement.= " WHERE `ActiveIND`=1;";
        }
        //echo $statement; for verifying
        $query = $db->query($statement);
        return $query;
    }

    public function query_Inventory($search, $where) {
        $statement = "SELECT `inventory`.invID, `type`.Description as \"Type\", `inventory`.Description, `inventory`.Cost, `inventory`.Quantity FROM `inventory` INNER JOIN `type` ON `inventory`.typID=`type`.typID ";
        $db = new DBA;
        $query;
        switch ($where) {

            case "invID": $statement.= "WHERE `invID` =\"" . $search. "\";";
                break;
            case "Type": $statement.= "WHERE `type`.`Description` =\"" . $search. "\";";
                break;

            default: $statement.= ";";
        }
       //echo $statement; //for verifying
        $query = $db->query($statement);
        return $query;
    }

    public function query_Orders($search, $where) {
        $statement = "SELECT `orders`.ordID,`customer`.FirstName AS \"Customer First Name\", `customer`.LastName AS \"Customer Last Name\",`employee`.FirstName AS \"Sales\",`employee`.LastName as \"Clerk\", `inventory`.Description, `type`.Description, `orders`.Details, `orders`.Date, `orders`.Quantity FROM `orders`
INNER JOIN `customer` ON `orders`.cusID=`customer`.cusID
INNER JOIN `inventory` ON `orders`.invID=`inventory`.invID
INNER JOIN `employee` ON `orders`.empID = `employee`.empID
INNER JOIN `type` ON `orders`.typID = `type`.typID ";
        $db = new DBA;
        $query;
        switch ($where) {
            case "ordID": $statement.= "WHERE `orders`.`ordID` =\"" . $search. "\";";
                break;
            case "custLastName": $statement.= "WHERE `customer`.`LastName` =\"" . $search. "\";";
                break;
            case "employeeLastName": $statement.= "WHERE `employee`.`LastName` =\"" . $search. "\";";
                break;
            case "Type": $statement.= "WHERE `type`.`Description` =\"" . $search. "\";";
                break;

            default: $statement.= ";";
        }
       echo $statement; //for verifying
        $query = $db->query($statement);
        return $query;
    }
}
?>