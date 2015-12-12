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
class MP_Paytrace_Model_Quote extends Mage_Core_Model_Abstract
{
	/**
	 * (non-PHPdoc)
	 * @see Varien_Object::_construct()
	 */
    public function _construct()
    {
        parent::_construct();
        $this->_init('mp_paytrace/quote');
    }

    /**
     * 
     * @param unknown $quote_id
     * @param unknown $var
     */
    public function deleteByQuote($quote_id, $var)
    {
        $this->_getResource()->deleteByQuote($quote_id, $var);
    }

    /**
     * 
     * @param unknown $quote_id
     * @param string $var
     */
    public function getByQuote($quote_id, $var = '')
    {
        return $this->_getResource()->getByQuote($quote_id, $var);
    }

}
