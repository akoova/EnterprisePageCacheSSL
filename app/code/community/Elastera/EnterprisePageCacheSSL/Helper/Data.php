<?php
/**
 * Page Cache SSL Helper
 *
 * @category  Elastera
 * @package   Elastera_EnterprisePageCacheSSL
 * @author    Florinel Chis <florinel@elastera.com>
 * @copyright 2014 Elastera (http://www.elastera.com)
 * @license   http://opensource.org/licenses/MIT MIT
 * @link      https://github.com/elastera/EnterprisePageCacheSSL
 */

/**
 * Page Cache SSL Helper
 *
 * @category Elastera
 * @package  Elastera_EnterprisePageCacheSSL
 * @author   Florinel Chis <florinel@elastera.com>
 * @license  @license   http://opensource.org/licenses/MIT MIT
 * @link     https://github.com/elastera/EnterprisePageCacheSSL
 */
class Elastera_EnterprisePageCacheSSL_Helper_Data extends Enterprise_PageCache_Helper_Data
{

    /**
     * Check if the request is secure or not
     *
     * @return bool
     */
    public static function isSSL()
    {

        $standardRule = !empty($_SERVER['HTTPS']) && ('off' != $_SERVER['HTTPS']);
        $offloaderHeader = trim((string) Mage::getConfig()->getNode(Mage_Core_Model_Store::XML_PATH_OFFLOADER_HEADER, 'default'));

        if ((!empty($offloaderHeader) && !empty($_SERVER[$offloaderHeader])) || $standardRule) {
            return true;
        }

        return false;
    }
}
