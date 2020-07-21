<?php

namespace Interview\Donation\Block\Adminhtml\Sales\Order\Invoice;

use Interview\Donation\Model\Config;
use Magento\Framework\View\Element\Template\Context;
use Magento\Sales\Model\Order\Invoice;

class Totals extends \Magento\Framework\View\Element\Template
{
    /**
     * @var Config
     */
    protected $_dataHelper;

    /**
     * Order invoice
     *
     * @var Invoice|null
     */
    protected $_invoice = null;

    /**
     * @var \Magento\Framework\DataObject
     */
    protected $_source;

    /**
     * constructor.
     *
     * @param Context $context
     * @param Config  $dataHelper
     * @param array   $data
     */
    public function __construct(
        Context $context,
            Config $dataHelper,
        array $data = []
    ) {
        $this->_dataHelper = $dataHelper;
        parent::__construct($context, $data);
    }

    /**
     * Get data (totals) source model
     *
     * @return \Magento\Framework\DataObject
     */
    public function getSource()
    {
        return $this->getParentBlock()->getSource();
    }

    public function getInvoice()
    {
        return $this->getParentBlock()->getInvoice();
    }
    /**
     * Initialize payment fee totals
     *
     * @return $this
     */
    public function initTotals()
    {
        $this->getParentBlock();
        $this->getInvoice();
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
