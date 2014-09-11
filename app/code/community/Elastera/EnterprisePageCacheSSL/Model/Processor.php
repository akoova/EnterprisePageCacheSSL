<?php
/**
 * Page Cache SSL Processor Model
 *
 * @category  Elastera
 * @package   Elastera_EnterprisePageCacheSSL
 * @author    Florinel Chis <florinel@elastera.com>
 * @copyright 2014 Elastera (http://www.elastera.com)
 * @license   http://opensource.org/licenses/MIT MIT
 * @link      https://github.com/elastera/EnterprisePageCacheSSL
 */

/**
 * Page Cache SSL Processor Model
 *
 * @category Elastera
 * @package  Elastera_EnterprisePageCacheSSL
 * @author   Florinel Chis <florinel@elastera.com>
 * @license  @license   http://opensource.org/licenses/MIT MIT
 * @link     https://github.com/elastera/EnterprisePageCacheSSL
 */
class Elastera_EnterprisePageCacheSSL_Model_Processor extends Enterprise_PageCache_Model_Processor
{

    /**
     * Check if processor is allowed for current HTTP(S) request.
     * HTTPS requests will be allowed (commented out the condition in the original Enterprise_PageCache_Model_Processor)
     * 
     *
     * @return bool
     */
    public function isAllowed()
    {
        if (!$this->_requestId) {
            return false;
        }
        
        /* start change - commented out the condition for HTTPS */
        /*
         * we want to cache HTTPS requests as well, different cache key though
         *
        if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') {
            return false;
        }
        */
        /* end change - commented out the condition for HTTPS */

        if (isset($_COOKIE['NO_CACHE'])) {
            return false;
        }
        if (isset($_GET['no_cache'])) {
            return false;
        }
        if (isset($_GET[Mage_Core_Model_Session_Abstract::SESSION_ID_QUERY_PARAM])) {
            return false;
        }
        if (!Mage::app()->useCache('full_page')) {
            return false;
        }

        return true;
    }

    /**
     * Populate request ids
     *
     * @return Elastera_PageCacheSSL_Model_Processor
     */
    protected function _createRequestIds()
    {

        parent::_createRequestIds();

        $uri = $this->_requestId;    
        
        if ($uri) {
            /* start change - add '_ssl' to the $uri if the request is SSL */
            if (Elastera_EnterprisePageCacheSSL_Helper_Data::isSSL()) {
                $uri .= '_ssl';
            }
            /* end change - add '_ssl' to the $uri if the request is SSL */
        }
        
        $this->_requestId       = $uri;
        $this->_requestCacheId  = $this->prepareCacheId($this->_requestId);
        return $this;
    }
}