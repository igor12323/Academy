<?php
namespace Bulbulatory\Recommendations\Block\Recommendation;

use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use Bulbulatory\Recommendations\Model\Recommendation;
use Magento\Customer\Model\Session;
class Index extends Template
{    
    protected $customCollection;
    protected $customer;

    public function __construct(Context $context, Recommendation $customCollection,Session $customer)
    {
        $this->customCollection = $customCollection;
        $this->customer=$customer->getCustomer();
        parent::__construct($context);
    }
    protected function _prepareLayout()
    {
        parent::_prepareLayout();
        if ($this->getCustomCollection()) {
            $pager = $this->getLayout()->createBlock(
                'Magento\Theme\Block\Html\Pager',
                'custom.history.pager'
            )->setAvailableLimit([5 => 5, 10 => 10, 15 => 15, 20 => 20])
                ->setShowPerPage(true)->setCollection(
                    $this->getCustomCollection()
                );
            $this->setChild('pager', $pager);
            $this->getCustomCollection()->load();
        }
        return $this;
    }
    public function getPagerHtml()
    {
        return $this->getChildHtml('pager');
    }
    public function getCustomCollection()
    {
        $page = ($this->getRequest()->getParam('p')) ? $this->getRequest()->getParam('p') : 1;
        $pageSize = ($this->getRequest()->getParam('limit')) ? $this->getRequest(
            
        )->getParam('limit') : 5;
        $collection = $this->customCollection->getCollection()
            ->addFieldToFilter("customer_id", array("eq" =>$this->customer->getId()));
        $collection->setPageSize($pageSize);
        $collection->setCurPage($page);
        return $collection;
    }
    
    public function getCountConfirmed()
    {
        $collection = $this->customCollection->getCollection()
            ->addFieldToFilter("customer_id", array("eq" =>$this->customer->getId()))
            ->addFieldToFilter("status",array("eq"=>1));
        return $collection->count();
    }
    public function getCountSended()
    {
        $collection = $this->customCollection->getCollection()
            ->addFieldToFilter("customer_id", array("eq" =>$this->customer->getId()));
        return $collection->count();
    }

    public function getDiscount()
    {
        return (int)floor($this->getCountConfirmed()/10)*5;
    }

    public function getStatusText(bool $status)
    {
        if($status)
        {
            return __("Confirmed");
        }
        return __("Unconfirmed");
    }

    public function getFormAction()
    {
        return '/bulbulatory_recommendations/recommendation/addRecommendation';
    } 
}
