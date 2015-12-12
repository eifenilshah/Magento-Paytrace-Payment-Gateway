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
class MP_Paytrace_Block_Revolution_Cc extends Mage_Paygate_Block_Authorizenet_Form_Cc
{
    /**
     * Retreive payment method form html
     *
     * @return string
     */
    public function getMethodFormBlock()
    {
        return $this->getLayout()->createBlock('mp_paytrace/form_cc')
            ->setMethod($this->getMethod());
    }
    
    /**
     * 
     * @return boolean
     */
    public function hasVerification()
    {
        return true;
    }

}