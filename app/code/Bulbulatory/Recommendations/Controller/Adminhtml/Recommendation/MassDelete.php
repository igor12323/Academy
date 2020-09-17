<?php

namespace Bulbulatory\Recommendations\Controller\Adminhtml\Recommendation;

use Magento\Backend\App\Action\Context;
use Magento\Ui\Component\MassAction\Filter;
use Bulbulatory\Recommendations\Model\ResourceModel\Recommendation\CollectionFactory;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\App\ResponseInterface;
use Bulbulatory\Recommendations\Model\Recommendation;
use Bulbulatory\Recommendations\Api\RecommendationRepositoryInterface;

class MassDelete extends \Magento\Backend\App\Action
{
    protected $filter;
    protected $collectionFactory;
    protected $recommendationRepository; 

    public function __construct(Context $context, Filter $filter, CollectionFactory $collectionFactory, RecommendationRepositoryInterface $recommendationRepository)
    {
        $this->filter = $filter;
        $this->collectionFactory = $collectionFactory;
        $this->recommendationRepository=$recommendationRepository;
        parent::__construct($context);
    }

    public function execute()
    {
        $collection = $this->filter->getCollection($this->collectionFactory->create());
        $collectionSize = $collection->getSize();
        
        foreach ($collection as $recommendation) {
            try {
                $id = $recommendation['recommendation_id'];
                $recommendation = $this->recommendationRepository->getById($id);
                $this->recommendationRepository->delete($recommendation);
            } catch (\Exception $e) {
                $this->messageManager->addError($e->getMessage()); 
             }
        }


        $this->messageManager->addSuccess(__('A total of %1 record(s) have been deleted.', $collectionSize));

        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        return $resultRedirect->setPath('*/*/');
    }
} 