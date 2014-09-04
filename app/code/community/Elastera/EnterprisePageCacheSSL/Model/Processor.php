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
     * HTTPS requests will be allowed.
     *
     * @return bool
     */
    public function isAllowed()
    {
        if (!$this->_requestId) {
            return false;
        }
        /*
         * we want to cache HTTPS requests as well, different cache key though
         *
        if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') {
            return false;
        }
        */
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
        $uri = $this->_getFullPageUrl();

        //Removing get params
        $pieces = explode('?', $uri);
        $uri = array_shift($pieces);

        /**
         * Define COOKIE state
         */
        if ($uri) {
            if (isset($_COOKIE['store'])) {
                $uri = $uri.'_'.$_COOKIE['store'];
            }
            if (isset($_COOKIE['currency'])) {
                $uri = $uri.'_'.$_COOKIE['currency'];
            }
            if (isset($_COOKIE[Enterprise_PageCache_Model_Cookie::COOKIE_CUSTOMER_GROUP])) {
                $uri .= '_' . $_COOKIE[Enterprise_PageCache_Model_Cookie::COOKIE_CUSTOMER_GROUP];
            }
            if (isset($_COOKIE[Enterprise_PageCache_Model_Cookie::COOKIE_CUSTOMER_LOGGED_IN])) {
                $uri .= '_' . $_COOKIE[Enterprise_PageCache_Model_Cookie::COOKIE_CUSTOMER_LOGGED_IN];
            }
            if (isset($_COOKIE[Enterprise_PageCache_Model_Cookie::CUSTOMER_SEGMENT_IDS])) {
                $uri .= '_' . $_COOKIE[Enterprise_PageCache_Model_Cookie::CUSTOMER_SEGMENT_IDS];
            }

            if (isset($_COOKIE[Enterprise_PageCache_Model_Cookie::IS_USER_ALLOWED_SAVE_COOKIE])) {
                $uri .= '_' . $_COOKIE[Enterprise_PageCache_Model_Cookie::IS_USER_ALLOWED_SAVE_COOKIE];
            }
            $designPackage = $this->_getDesignPackage();

            if ($designPackage) {
                $uri .= '_' . $designPackage;
            }

            if (Elastera_EnterprisePageCacheSSL_Helper_Data::isSSL()) {
                $uri .= '_ssl';
            }
        }

        $this->_requestId       = $uri;
        $this->_requestCacheId  = $this->prepareCacheId($this->_requestId);

        return $this;
    }
}