<?php
namespace Bulbulatory\Recommendations\Controller\Adminhtml\Recommendation;
 
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Bulbulatory\Recommendations\Api\RecommendationRepositoryInterface;
 
class Delete extends Action
{
    protected $recommendationRepository;
 
    public function __construct(Context $context, RecommendationRepositoryInterface $recommendationRepository)
    {
        parent::__construct($context);
        $this->recommendationRepository = $recommendationRepository;
    }
 
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Bulbulatory_recommendations::recommendation');
    }
 
    public function execute()
    {
        $id = $this->getRequest()->getParam('recommendation_id');
        $resultRedirect = $this->resultRedirectFactory->create();
        if ($id) {
            try {
                $recommendation = $this->recommendationRepository->getById($id);
                $this->recommendationRepository->delete($recommendation);
                $this->messageManager->addSuccessMessage(__('Recommendation deleted.'));
            } catch (\Exception $e) {
                $this->messageManager->addError($e->getMessage());}
        }
        else{
        $this->messageManager->addError(__('Recommendation does not exist.'));
        }
        return $resultRedirect->setPath('*/*/');
    }
}