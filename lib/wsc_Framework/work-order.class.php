<?php
/**
* This class will handle all Work-Order processes
*
* @package      workOrder
* @category     Agent
* @author       James R. Coltman <iamthecoltman@gmail.com>
*/

namespace WSC\Framework\Agents;

use WSC\Framework\Agents\Customer;
use WSC\Framework\Agents\workOrder;

require_once "cust.class.php";

class WorkOrder {
    protected $empID;
    protected $jobType;
    protected $mediaType;
    protected $content;

    protected $customer;      # Object: customer

    public function __construct($empID, $custType, $type, $content) {
        $this->customer = new Customer;
        $this->set_work_order($empID, $custType, $type, $content);
    }

    private function set_work_order($empID, $custType, $type, $content, $cust_data = null) {

        switch ($custType) {
            case 'existing':
                # code...
                break;

            case 'new':
                if ($cust_data != null) {
                    $this->customer->set_customer($cust_data);
                }
                break;

            default:
                # code...
                break;
        }

        // if ($custType == 'new') {
        //     // New customer
        // } elseif ($custType == 'existing') {
        //     // Existing customer
        // } else {
        //     // Error
        // }
    }
}
?>