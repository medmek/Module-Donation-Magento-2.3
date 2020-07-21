define(
    [
        'jquery',
        'ko',
        'uiComponent',
        'underscore',
        'Magento_Checkout/js/model/step-navigator',
        'Magento_Checkout/js/model/error-processor',
        'Magento_Checkout/js/model/full-screen-loader',
        'Magento_Checkout/js/model/quote',
        'Magento_Checkout/js/view/summary/abstract-total',
        'Magento_Catalog/js/price-utils',
        'Magento_Checkout/js/checkout-data',
        'Magento_Customer/js/customer-data',
        'mage/translate'
    ],
    function (
        $,
        ko,
        Component,
        _,
        stepNavigator,
        errorProcessor,
        fullScreenLoader,
        quote,
        abstractTotal,
        priceUtils,
        checkoutData,
        storage,
        $t
    ) {
        'use strict';

        var cacheKey = 'checkout-data';

        return Component.extend({
            defaults: {
                template: 'Interview_Donation/donation_step'
            },

            isVisible: ko.observable(true),
            getTitle: ko.observable(window.checkoutConfig.donation.title),
            getDescription: ko.observable(window.checkoutConfig.donation.description),
            getImageSource: ko.observable(window.checkoutConfig.donation.imageSrc),
            getFormattedAmount: ko.observable(priceUtils.formatPrice(window.checkoutConfig.donation.amount, quote.getPriceFormat())),

            /**
             *
             * @returns {*}
             */
            initialize: function () {
                this._super();
                stepNavigator.registerStep(
                    'donation_step',
                    null,
                    $t('Donation'),
                    //observable property with logic when display step or hide step
                    this.isVisible,
                    _.bind(this.navigate, this),
                    15
                );

                return this;
            },

            initObservable: function () {
                this._super()
                    .observe({
                        DonationCheckbox: ko.observable(false)
                    });

                this.DonationCheckbox.subscribe(function (newValue) {
                    fullScreenLoader.startLoader();
                    var data = storage.get(cacheKey)();
                    var totals = quote.getTotals();
                    var totalSegments =  totals().total_segments
                    var donationSegment = {
                        code: 'fee',
                        title: window.checkoutConfig.donation.title,
                        value: priceUtils.formatPrice(window.checkoutConfig.donation.amount, quote.getPriceFormat()),
                        area: null
                    };

                    if(newValue){
                        console.log('checked');
                        totalSegments.push(donationSegment);
                    }else{
                        console.log('Unchecked');
                        //unset fee segment
                        totalSegments = array.filter(
                            function(value, index, totalSegments){
                                return value.code !== donationSegment.code;
                            });
                    }

                    storage.set(cacheKey, data);
                    fullScreenLoader.stopLoader();
                });

                return this;
            },

            navigate: function () {
                this.isVisible(true);
            },

            /**
             * @returns void
             */
            navigateToNextStep: function () {
                stepNavigator.next();
            },
        });
    }
);
