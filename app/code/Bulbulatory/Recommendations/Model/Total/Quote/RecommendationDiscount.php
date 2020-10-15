<?php
namespace Bulbulatory\Recommendations\Model\Total\Quote;

use Magento\Quote\Model\Quote\Address\Total\AbstractTotal;
use Magento\Framework\Pricing\PriceCurrencyInterface;
use Magento\Quote\Model\Quote;
use Magento\Quote\Api\Data\ShippingAssignmentInterface;
use Magento\Quote\Model\Quote\Address\Total;
use Bulbulatory\Recommendations\Block\Recommendation\Index;
use Magento\Framework\App\Config\ScopeConfigInterface;

class RecommendationDiscount extends AbstractTotal
{
    protected $_priceCurrency;
    protected $recommendations;
    protected $config;
    private $percentDiscount=0;
    
    public function __construct(ScopeConfigInterface $config,PriceCurrencyInterface $priceCurrency, Index $recommendations)
    {

        $this->_priceCurrency = $priceCurrency;
        $this->recommendations=$recommendations;
        $this->config = $config;
        
    }
 
    public function collect(Quote $quote, ShippingAssignmentInterface $shippingAssignment, Total $total)
    {
        parent::collect($quote, $shippingAssignment, $total);
        if(!$this->config->isSetFlag('recommendations/general/enable'))
        {
            return $this;
        }
        $this->percentDiscount=($this->recommendations->getDiscount())/100;
        if ($this->percentDiscount == 0) 
        {
            return $this;
        }
        $baseDiscount =$total->getSubtotal()*($this->percentDiscount);
        $discount = $this->_priceCurrency->convert($baseDiscount);
        $total->addTotalAmount('recommendationdiscount', -$discount);
        $total->addBaseTotalAmount('recommendationdiscount', -$baseDiscount);
        $total->setBaseGrandTotal($total->getBaseGrandTotal() - $baseDiscount);
        $quote->setRecommendationDiscount(-$discount);
        return $this;
    }
    public function fetch(Quote $quote, Total $total)
    {
        if($this->percentDiscount>0)
        {
            return [
                'code' => 'recommendation_discount',
                'title' => $this->getLabel(),
                'value' => -$total->getSubtotal()*$this->percentDiscount
        ];
        }
        return null;
    }
    public function getLabel()
    {
        return __('Recommendation Discount');
    }
}
