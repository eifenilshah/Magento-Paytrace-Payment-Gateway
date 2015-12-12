<?php
/**
 * @author Jonathon Byrd (https://merchantprotocol.com)
 * @copyright  Copyright (c) 2015 Merchant Protocol
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

/**
 * 
 * @author anonymous
 *
 */
class MP_Paytrace_Model_Order extends Mage_Core_Model_Abstract
{
	/**
	 * (non-PHPdoc)
	 * @see Varien_Object::_construct()
	 */
    public function _construct() {
        parent::_construct();
        $this->_init('mp_paytrace/order');
    }
    
    /**
     * 
     * @param unknown $order_id
     * @param unknown $var
     */
    public function deleteByOrder($order_id, $var) {
        $this->_getResource()->deleteByOrder($order_id, $var);
    }
    
    /**
     * 
     * @param unknown $order_id
     */
    public function deleteOrder($order_id) {
        return $this->_getResource()->deleteOrder($order_id);
    }
    
    /**
     * 
     * @param unknown $order_id
     * @param string $var
     */
    public function getByOrder($order_id, $var = '') {
        return $this->_getResource()->getByOrder($order_id, $var);
    }
    
    /**
     * 
     * @param unknown $prop
     * @param string $val
     */
    public function getByOrderMeta($prop, $val='') {
        return $this->_getResource()->getByOrderMeta($prop, $val);
    }
}
