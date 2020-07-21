<?php
namespace Interview\Donation\Model;

use Magento\Checkout\Model\ConfigProviderInterface;

class DonationConfigProvider implements ConfigProviderInterface
{
    /**
     * Core store config
     *
     * @var Config
     */
    protected $_donationConfig;

    /**
     * @param Config $donationConfig
     */
    public function __construct(Config $donationConfig)
    {
        $this->_donationConfig = $donationConfig;
    }

    public function getConfig()
    {
        $config = [];

        if($this->_donationConfig->isDonationEnabled()) {
            $config['donation']['enabled'] = $this->_donationConfig->isDonationEnabled();
            $config['donation']['title'] = $this->_donationConfig->getDonationBlockTitle();
            $config['donation']['description'] = $this->_donationConfig->getDonationBlockDescription();
            $config['donation']['amount'] = $this->_donationConfig->getDonationAmount();
            $config['donation']['imageSrc'] = $this->_donationConfig->getDonationBlockImageSource();
        }

        return $config;
    }


}
