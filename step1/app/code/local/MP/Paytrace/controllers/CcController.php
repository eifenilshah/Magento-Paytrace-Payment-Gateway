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
class MP_Paytrace_CcController extends Mage_Core_Controller_Front_Action
{
    
    /**
     * We only want logged in users working on these cards
     */
    protected function isAuthorized() {
        if (!Mage::helper('customer')->isLoggedIn()) {
            header('Location: '. Mage::getUrl() );
            die;
        }
    }
    
    /**
     * 
     */
    protected function isAuthorizedCard() {
        $cardModel = Mage::registry('current_card');
        
        $customerId = Mage::helper('customer')->getCustomer()->getId();
        if ($cardModel->getCustomerId() == $customerId) 
            return true;
        return false;
    }
    
    /**
     * List of credit cards
     */
    public function indexAction() {
        $this->isAuthorized();
        $this->loadLayout();
        $this->renderLayout();
    }
    
    /**
     * Prepares to edit a card or create a new one
     * 
     * 
     * UPDATE THE PAYTRACE CUSTOMER
     * http://help.paytrace.com/api-update-customer-profile
     * 
     */
    public function editAction() {
        $this->isAuthorized();
        
        $cardModel = Mage::getModel('mp_paytrace/card');
        
        // loading an existing card
        $card_id = $this->getRequest()->getParam('card_id', false);
        if ($card_id) {
            $cardModel->load($card_id);
        }
        
        Mage::register('current_card', $cardModel);
        
        // Make sure this is the right user
        $this->isAuthorizedCard();
        
        $this->loadLayout();
        $this->renderLayout();
    }
    
    /**
     * Deletes a credit card
     */
    public function deleteAction() {
        $this->isAuthorized();
        
        $card_id = $this->getRequest()->getParam('card_id', false);
        $cardModel = Mage::getModel('mp_paytrace/card')->load($card_id);
        $dleted = $cardModel->delete();
        
        // UPDATE A NEW CUSTOMER at paytrace
        Mage::helper('mp_paytrace/paytrace')->paytraceCustomer( 
                Mage::getSingleton('customer/session')->getCustomer()
                );
        
        if ($dleted) {
            $message = $this->__("Your card was deleted.");
            Mage::getSingleton('core/session')->addSuccess($message);
        } else {
            $message = $this->__("Your card could not be deleted.");
            Mage::getSingleton('core/session')->addError($message);
        }
        $this->_redirectUrl( Mage::getUrl()."mp_paytrace/cc/" );
    }
    
    /**
     * Saves a credit card
     * 
     * 
     * CREATE A NEW CUSTOMER 
     */
    public function saveAction() {
        $this->isAuthorized();
        
        $cardModel = Mage::helper('mp_paytrace')->savePostedCard();
        
        if (!$cardModel->getToken()) {
            $message = $this->__("Your card was saved.");
            Mage::getSingleton('core/session')->addSuccess($message);
        } else {
            Mage::getSingleton('core/session')->addError($cardModel->getToken());
        }
        
        if (!trim($cardModel->getToken())) {
            $this->_redirectUrl( Mage::getUrl()."mp_paytrace/cc/" );
            return;
        }
        $this->_redirectUrl( Mage::getUrl()."mp_paytrace/cc/edit/?card_id=".$cardModel->getId() );
    }
}
