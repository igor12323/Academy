<?php
namespace Bulbulatory\Recommendations\Controller\Recommendation;

use Magento\Framework\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;
use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\Controller\ResultFactory;
use Magento\Customer\Model\Session;

class Index extends Action
{
	protected $_pageFactory;
	protected $scopeConfig;
	protected $customer;
	public function __construct(Context $context, Session $customer, PageFactory $pageFactory,ScopeConfigInterface $scopeConfig)
	 {
		$this->_pageFactory=$pageFactory;
		$this->customer=$customer;
		$this->scopeConfig = $scopeConfig;
		return parent::__construct($context);
	}

	public function execute()
	{
		if ($this->customer->getId())
		{
			if($this->scopeConfig->isSetFlag('recommendations/general/enable'))
			{
				return $this->_pageFactory->create();
			}
			else
			{
				$this->messageManager->addErrorMessage(__('Module disabled.'));
			}
		}
		else
		{
			$this->messageManager->addErrorMessage(__('Module disabled for logged out users.'));
		}
		$resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
		$resultRedirect->setUrl('/customer/account/');
        return $resultRedirect;
	}
}