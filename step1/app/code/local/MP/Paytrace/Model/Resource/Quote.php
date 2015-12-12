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
class MP_Paytrace_Model_Resource_Quote extends Mage_Core_Model_Mysql4_Abstract
{
	/**
	 * (non-PHPdoc)
	 * @see Mage_Core_Model_Resource_Abstract::_construct()
	 */
    public function _construct() {
        $this->_init('mp_paytrace/quote', 'id');
    }

    /**
     * 
     * @param unknown $quote_id
     * @param unknown $var
     */
    public function deleteByQuote($quote_id, $var)
    {
        $table = $this->getMainTable();
        $where = $this->_getWriteAdapter()->quoteInto('quote_id = ? AND ', $quote_id)
                . $this->_getWriteAdapter()->quoteInto('`key` = ? 	', $var);
        $this->_getWriteAdapter()->delete($table, $where);
    }

    /**
     * 
     * @param unknown $quote_id
     * @param string $var
     * @return multitype:unknown
     */
    public function getByQuote($quote_id, $var = '')
    {
        $table = $this->getMainTable();
        $where = $this->_getReadAdapter()->quoteInto('quote_id = ?', $quote_id);
        if (!empty($var)) {
            $where .= $this->_getReadAdapter()->quoteInto(' AND `key` = ? ', $var);
        }
        $sql = $this->_getReadAdapter()->select()->from($table)->where($where);
        $rows = $this->_getReadAdapter()->fetchAll($sql);
        $return = array();
        foreach ($rows as $row) {
            $return[$row['key']] = $row['value'];
        }
        return $return;
    }
}
