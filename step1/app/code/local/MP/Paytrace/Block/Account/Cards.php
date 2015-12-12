<?php
/**
 * @author Jonathon Byrd (https://merchantprotocol.com)
 * @copyright  Copyright (c) 2015 Merchant Protocol
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

/**
 * Description of Creditcards
 *
 * @author Jonathon
 */
class MP_Paytrace_Block_Account_Cards extends Mage_Core_Block_Template {
    
    /**
     * @TODO b4requirements get the list of saved credit cards
     * 
     * 
     * @return type
     */
    public function getCards() {
        return Mage::helper('mp_paytrace')->getCards();
    }
}
