<?php
namespace Interview\Donation\Model\Quote\Total;

class DonationTotal extends \Magento\Quote\Model\Quote\Address\Total\AbstractTotal
{
    /**
     * @var \Interview\Donation\Model\Config
     */
    protected $helperData;
    /**
     * @var \Magento\Framework\Pricing\PriceCurrencyInterface
     */
    protected $_priceCurrency;
    /**
     * @var \Magento\Quote\Model\QuoteValidator|null
     */
    protected $quoteValidator = null;

    /**
     * DonationTotal constructor.
     *
     * @param \Magento\Quote\Model\QuoteValidator               $quoteValidator
     * @param \Magento\Framework\Pricing\PriceCurrencyInterface $priceCurrency
     * @param \Interview\Donation\Model\Config                  $helperData
     */
    public function __construct(
        \Magento\Quote\Model\QuoteValidator $quoteValidator,
        \Magento\Framework\Pricing\PriceCurrencyInterface $priceCurrency,
        \Interview\Donation\Model\Config $helperData)
    {
        $this->quoteValidator = $quoteValidator;
		$this->_priceCurrency = $priceCurrency;
        $this->helperData = $helperData;
    }

    /**
     * Collect grand total address amount
     *
     * @param \Magento\Quote\Model\Quote $quote
     * @param \Magento\Quote\Api\Data\ShippingAssignmentInterface $shippingAssignment
     * @param \Magento\Quote\Model\Quote\Address\Total $total
     *
     * @return $this
     */
    public function collect(
        \Magento\Quote\Model\Quote $quote,
        \Magento\Quote\Api\Data\ShippingAssignmentInterface $shippingAssignment,
        \Magento\Quote\Model\Quote\Address\Total $total
    )
    {
        parent::collect($quote, $shippingAssignment, $total);
        if (!count($shippingAssignment->getItems())) {
            return $this;
        }

        $enabled = $this->helperData->isDonationEnabled();
        if ($enabled) {
            $fee = $this->helperData->getDonationAmount();
            //Try to test with sample value
            //$fee=50;
            $total->setTotalAmount('fee', $fee);
            $total->setBaseTotalAmount('fee', $fee);
            $total->setFee($fee);
            $quote->setFee($fee);


			$objectManager = \Magento\Framework\App\ObjectManager::getInstance();
			$productMetadata = $objectManager->get('Magento\Framework\App\ProductMetadataInterface');
            $total->setGrandTotal($total->getGrandTotal() + $fee);

		}
        return $this;
    }

    /**
     * @param \Magento\Quote\Model\Quote $quote
     * @param \Magento\Quote\Model\Quote\Address\Total $total
     * @return array
     */
    public function fetch(\Magento\Quote\Model\Quote $quote, \Magento\Quote\Model\Quote\Address\Total $total)
    {
        $enabled = $this->helperData->isDonationEnabled();
        $fee = $quote->getFee();

        $result = [];
        if ($enabled && $fee) {
            $result = [
                'code' => 'fee',
                'title' => $this->helperData->getDonationBlockTitle(),
                'value' => $fee
            ];
        }
        return $result;
    }

    /**
     * @param \Magento\Quote\Model\Quote\Address\Total $total
     */
    protected function clearValues(\Magento\Quote\Model\Quote\Address\Total $total)
    {
        $total->setTotalAmount('subtotal', 0);
        $total->setBaseTotalAmount('subtotal', 0);
        $total->setTotalAmount('tax', 0);
        $total->setBaseTotalAmount('tax', 0);
        $total->setTotalAmount('discount_tax_compensation', 0);
        $total->setBaseTotalAmount('discount_tax_compensation', 0);
        $total->setTotalAmount('shipping_discount_tax_compensation', 0);
        $total->setBaseTotalAmount('shipping_discount_tax_compensation', 0);
        $total->setSubtotalInclTax(0);
        $total->setBaseSubtotalInclTax(0);

    }
}
