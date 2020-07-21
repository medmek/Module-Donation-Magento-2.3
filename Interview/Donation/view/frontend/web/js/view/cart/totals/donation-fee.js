define([
    'ko',
    'uiComponent',
    'Magento_Checkout/js/model/quote',
    'Magento_Catalog/js/price-utils',
    'Magento_Checkout/js/model/totals'

], function (ko, Component, quote, priceUtils, totals) {
    'use strict';
    var donationEnabled = window.checkoutConfig.donation.enabled;
    var fee_label = window.checkoutConfig.donation.title;
    var custom_fee_amount = window.checkoutConfig.donation.amount;

    return Component.extend({

        totals: quote.getTotals(),
        canVisibleExtrafeeBlock: donationEnabled,
        getFormattedPrice: ko.observable(priceUtils.formatPrice(custom_fee_amount, quote.getPriceFormat())),
        getFeeLabel:ko.observable(fee_label),
        isDisplayed: function () {
            return this.getValue() != 0;
        },
        getValue: function() {
            var price = 0;
            if (this.totals() && totals.getSegment('fee')) {
                price = totals.getSegment('fee').value;
            }
            return price;
        }
    });
});
