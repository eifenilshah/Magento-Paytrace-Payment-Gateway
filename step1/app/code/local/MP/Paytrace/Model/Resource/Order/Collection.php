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
class MP_Paytrace_Model_Resource_Order_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract
{
	/**
	 * (non-PHPdoc)
	 * @see Mage_Core_Model_Resource_Db_Collection_Abstract::_construct()
	 */
    public function _construct()
    {
        parent::_construct();
        $this->_init('mp_paytrace/order');
    }
}