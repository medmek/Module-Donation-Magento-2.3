<?php

namespace Interview\Donation\Block\Adminhtml\Sales;

use Interview\Donation\Model\Config;
use Magento\Directory\Model\Currency;
use Magento\Framework\View\Element\Template\Context;
use Magento\Sales\Model\Order;

class Totals extends \Magento\Framework\View\Element\Template
{
    /**
     * @var Config
     */
    protected $_dataHelper;


    /**
     * @var Currency
     */
    protected $_currency;

    /**
     * Totals constructor.
     *
     * @param Context  $context
     * @param Config   $dataHelper
     * @param Currency $currency
     * @param array    $data
     */
    public function __construct(
        Context $context,
        Config $dataHelper,
        Currency $currency,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->_dataHelper = $dataHelper;
        $this->_currency = $currency;
    }

    /**
     * Retrieve current order model instance
     *
     * @return Order
     */
    public function getOrder()
    {
        return $this->getParentBlock()->getOrder();
    }

    /**
     * @return mixed
     */
    public function getSource()
    {
        return $this->getParentBlock()->getSource();
    }

    /**
     * @return string
     */
    public function getCurrencySymbol()
    {
        return $this->_currency->getCurrencySymbol();
    }

    /**
     *
     *
     * @return $this
     */
    public function initTotals()
    {
        $this->getParentBlock();
        $this->getOrder();
        $this->getSource();

        if(!$this->getSource()->getFee()) {
            return $this;
        }
        $total = new \Magento\Framework\DataObject(
            [
                'code' => 'fee',
                'value' => $this->getSource()->getFee(),
                'label' => $this->_dataHelper->getDonationBlockTitle(),
            ]
        );
        $this->getParentBlock()->addTotalBefore($total, 'grand_total');

        return $this;
    }
}
