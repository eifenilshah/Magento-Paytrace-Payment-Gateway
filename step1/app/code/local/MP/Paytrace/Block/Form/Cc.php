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
class MP_Paytrace_Block_Form_Cc extends Mage_Payment_Block_Form_Cc
{
    /**
     * (non-PHPdoc)
     * @see Mage_Payment_Block_Form_Cc::_construct()
     */
    protected function _construct()
    {
        parent::_construct();
        $this->setTemplate('paytrace/form/cc.phtml');
    }
}