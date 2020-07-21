<?php
/**
* Configuration paths storage
*/
namespace Interview\Donation\Model;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Store\Model\ScopeInterface;
use Magento\Store\Model\StoreManagerInterface;

class Config
{
    const XML_PATH_DONATION_ENABLE_DONATION = 'donation/donation/enable_donation';
    const XML_PATH_DONATION_BLOCK_TITLE = 'donation/donation/donation_block_title';
    const XML_PATH_DONATION_BLOCK_DESCRIPTION = 'donation/donation/donation_block_description';
    const XML_PATH_DONATION_BLOCK_IMAGE = 'donation/donation/donation_block_image';
    const XML_PATH_DONATION_AMOUNT = 'donation/donation/donation_amount';

    /**
     * Core store config
     *
     * @var ScopeConfigInterface
     */
    protected $_scopeConfig;

    /**
     * @var StoreManagerInterface
     */
    protected $_storeManager;

    /**
     * @param ScopeConfigInterface  $scopeConfig
     * @param StoreManagerInterface $storeManager
     */
    public function __construct(
        ScopeConfigInterface $scopeConfig,
        StoreManagerInterface $storeManager
    ) {
        $this->_scopeConfig = $scopeConfig;
        $this->_storeManager = $storeManager;
    }

    /**
     * Return the flag for donation features
     *
     * @return bool
     */
    public function isDonationEnabled()
    {
        return (bool)$this->_scopeConfig->getValue(
            self::XML_PATH_DONATION_ENABLE_DONATION,
            ScopeInterface::SCOPE_STORE
        );
    }

    /**
     * Return the donation block title
     *
     * @return string
     */
    public function getDonationBlockTitle()
    {
        return $this->_scopeConfig->getValue(
            self::XML_PATH_DONATION_BLOCK_TITLE,
            ScopeInterface::SCOPE_STORE
        );
    }

    /**
     * Return the donation block description
     *
     * @return string
     */
    public function getDonationBlockDescription()
    {
        return $this->_scopeConfig->getValue(
            self::XML_PATH_DONATION_BLOCK_DESCRIPTION,
            ScopeInterface::SCOPE_STORE
        );
    }

    /**
     * Return the donation block image filepath
     *
     * @return string
     */
    public function getDonationBlockImageSource()
    {
        return $this->_storeManager->getStore()->getBaseUrl(
                DirectoryList::MEDIA
            ) . 'interview/donation/' . $this->_scopeConfig->getValue(
            self::XML_PATH_DONATION_BLOCK_IMAGE,
            ScopeInterface::SCOPE_STORE
        );
    }

    /**
     * Return the donation amount
     *
     * @return int
     */
    public function getDonationAmount()
    {
        return $this->_scopeConfig->getValue(
            self::XML_PATH_DONATION_AMOUNT,
            ScopeInterface::SCOPE_STORE
        );
    }
}
