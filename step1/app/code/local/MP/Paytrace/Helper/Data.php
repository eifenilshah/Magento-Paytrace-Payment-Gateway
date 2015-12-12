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
class MP_Paytrace_Helper_Data extends Mage_Paygate_Helper_Data
{    
	const OPTIONSID = '453465';
	
    /**
     * Retrieve information from payment configuration
     *
     * @param string $field
     * @param int|string|null|Mage_Core_Model_Store $storeId
     *
     * @return mixed
     */
    public function getConfigData($field, $storeId = null)
    {
        if (null === $storeId) {
            $storeId = Mage::app()->getStore()->getId();
        }
        $path = 'payment/mp_paytrace/'.$field;
        return Mage::getStoreConfig($path, $storeId);
    }
    
    /**
     * 
     * @return mixed
     */
    public function isLevel3Enabled()
    {
    	return $this->getConfigData('enable_level3');
    }
    
    /**
     * @TODO b4requirements get the list of saved credit cards
     * 
     * 
     * @return type
     */
    public function getCards( $customerId =null ) {
        if (!$customerId) {
            $customerObj = Mage::getSingleton('customer/session')->getCustomer();
            $customerId = $customerObj->getId();
        }
        
        $cardCollection = Mage::getResourceModel('mp_paytrace/card_collection')
                ->addFieldToFilter('customer_id', array('in' => array($customerId)))
                ->load();
        
        return $cardCollection;
    }
    
    /**
     * 
     * @param type $customerId
     */
    public function getPrimaryCard( $customerId =null ) {
        if (!$customerId) {
            $customer = Mage::getSingleton('customer/session')->getCustomer();
            $customerId = $customer->getId();
        }
        
        $cardCollection = Mage::getResourceModel('mp_paytrace/card_collection')
                ->addFieldToFilter('customer_id', $customerId)
                ->addFieldToFilter('primary', "1")
                ->load();
        
        $card = $cardCollection->getFirstItem();
        if (!$card->getId()) {
            $card = $this->getCards()->getLastItem();
        }
        return $card;
    }
    
    /**
     * 
     */
    public function clearAllPrimaries() {
        foreach($this->getCards() as $card) {
            $card->setPrimary(0);
            $card->save();
        }
    }
    
    /**
     * Clears all saved cards in the users name
     */
    public function clearAllSavedCards(){
        foreach($this->getCards() as $card) {
            $card->delete();
        }
    }
    
    /**
     * 
     */
    public function savePostedCard() {
        
        $this->clearAllSavedCards();
        $cardModel = Mage::getModel('mp_paytrace/card');
        
        $params = Mage::app()->getRequest()->getParam('payment');
        if (isset($params['saved_card_id'])) {
            $cardModel->load($params['saved_card_id']);
        }
        
        $cardModel->setToken('');
        $cardModel->setName($params['cc_owner']);
        $cardModel->setNumber($params['cc_number']);
        $cardModel->setType($params['cc_type']);
        $cardModel->setMonth($params['cc_exp_month']);
        $cardModel->setYear($params['cc_exp_year']);
        
        if (!$params['cc_number']) {
            $cardModel->setToken('35. Invalid credit card number.');
        }
        
        $customerObj = Mage::getSingleton('customer/session')->getCustomer();
        $customerId = $customerObj->getId();
        $cardModel->setCustomerId($customerId);
        
//        $primary = $params['primary']=='on'?1:0;
        $primary = 1;
        $cardModel->setData('primary', $primary);
//        if ($primary) {
//            $this->clearAllPrimaries();
//        }

        Mage::dispatchEvent('mp_paytrace_card_save', array(
            'card' => $cardModel,
            'params' => $params
        ));
        
        Mage::helper('mp_paytrace/paytrace')->paytraceCustomer($customerObj,$cardModel);
        
        $number = $cardModel->getNumber();
        $number = substr($number,-4);
        $cardModel->setNumber($number);
        $cardModel->save();
        
        return $cardModel;
    }
}