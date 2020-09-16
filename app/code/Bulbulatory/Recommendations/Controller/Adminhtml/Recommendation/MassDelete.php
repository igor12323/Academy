<?php

namespace Bulbulatory\Recommendations\Controller\Adminhtml\Recommendation;

use Magento\Backend\App\Action\Context;
use Magento\Ui\Component\MassAction\Filter;
use Bulbulatory\Recommendations\Model\ResourceModel\Recommendation\CollectionFactory;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\App\ResponseInterface;
use Bulbulatory\Recommendations\Model\Recommendation;

class MassDelete extends \Magento\Backend\App\Action
{
    protected $filter;
    protected $collectionFactory;

    public function __construct(Context $context, Filter $filter, CollectionFactory $collectionFactory)
    {
        $this->filter = $filter;
        $this->collectionFactory = $collectionFactory;
        parent::__construct($context);
    }

    public function execute()
    {
        $collection = $this->filter->getCollection($this->collectionFactory->create());
        $collectionSize = $collection->getSize();
        $model = $this->_objectManager->create(Recommendation::class);

        foreach ($collection as $item) {
                $id = $item['recommendation_id'];
                $model->load($id);
                $model->delete();
            }
        
        $this->messageManager->addSuccess(__('A total of %1 record(s) have been deleted.', $collectionSize));

        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        return $resultRedirect->setPath('*/*/');
    }
} 