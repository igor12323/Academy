<?php
namespace Bulbulatory\Recommendations\Block\Recommendation;


class Index extends \Magento\Framework\View\Element\Template
{    
    public function _prepareLayout()
    {
        return parent::_prepareLayout();
    }
    public function getFormAction()
    {
        return '/bulbulatory_recommendations/recommendation/addRecommendation';
    } 
}