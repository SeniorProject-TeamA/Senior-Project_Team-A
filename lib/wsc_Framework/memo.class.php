<?php
/**
* This class handles all of the memo functions
*
* @package      Memo
* @category     Agent
* @author       James R. Coltman <iamthecoltman@gmail.com>
*/

namespace WSC\Framework\Agents;

use WSC\Framework\Agents\Memo;

/**
 * [description]
 *
 * [Detailed Description]
 */
class Memo {
    /**
     * [$message description]
     * @var [type]
     */
    private $message;

    /**
     * [$target description]
     * @var [type]
     */
    private $target;

    /**
     * [$orderId description]
     * @var [type]
     */
    private $orderId;

    /**
     * [__construct description]
     * @param [type] $message [description]
     * @param [type] $target  [description]
     * @param [type] $orderId [description]
     */
    public function __construct($message,$target,$orderId) {
        echo "Class: (" . __CLASS__ . ") Instantiated!" . PHP_EOL;

        $this->setMessage($message);

        $this->setTarget($target);

        $this->setOrderId($orderId);

        $this->constructMemo($message, $target, $orderId);
    }

    /**
     * [setMessage description]
     * @param [type] $message [description]
     */
    private function setMessage($message) {
        $this->message = $message;
    }

    /**
     * [setTarget description]
     * @param [type] $target [description]
     */
    private function setTarget($target) {
        $this->target = $target;
    }

    /**
     * [setTarget description]
     * @param [type] $target [description]
     */
    private function setOrderID($orderId) {
        $this->orderId = $orderId;
    }

    /**
     * [getMessage description]
     * @return [type] [description]
     */
    public function getMessage() {
        return $this->$message;
    }

    /**
     * [getMessage description]
     * @return [type] [description]
     */
    public function getTarget() {
        return $this->$target;
    }

    /**
     * [getMessage description]
     * @return [type] [description]
     */
    public function getOrderID() {
        return $this->$orderId;
    }

    /**
     * [getMessage description]
     * @return [type] [description]
     */
    public function constructMemo() {
        $result;

        $result = "Attn ".$this->target.": Ref Order ".$this->orderId.'<br>'.$this->message;

        return $result;

    }
}