    
define(
    [
        'jquery',
        'Magento_Checkout/js/view/summary/abstract-total',
        'Magento_Checkout/js/model/quote',
        'Magento_Checkout/js/model/totals'
    ],
    function ($,Component,quote,totals) 
    {
        "use strict";
        return Component.extend
        (
            {
                defaults: 
                {
                    template: 'Bulbulatory_Recommendations/checkout/summary/recommendationdiscount'
                },
                totals: quote.getTotals(),
                isDisplayedRecommendationdiscount : function()
                {
                    if(totals.getSegment('recommendation_discount')!=null)
                    {
                        return true;
                    }
                    return false;
                },
                getRecommendationDiscount : function()
                {
                    return this.getFormattedPrice(totals.getSegment('recommendation_discount').value);
                }
            }
        )
    }
);
