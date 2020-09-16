<?php
namespace Bulbulatory\Recommendations\Controller\Adminhtml\Recommendation;
 
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Bulbulatory\Recommendations\Model\Recommendation;
 
class Delete extends Action
{
    protected $_model;
 
    public function __construct(Context $context, Recommendation $model)
    {
        parent::__construct($context);
        $this->_model = $model;
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
                $model = $this->_model;
                $model->load($id);
                $model->delete();
                $this->messageManager->addSuccess(__('Recommendation deleted ',$id));
                return $resultRedirect->setPath('*/*/');
            } catch (\Exception $e) {
                $this->messageManager->addError($e->getMessage());
                return $resultRedirect->setPath('*/*/');
            }
        }
        $this->messageManager->addError(__('Recommendation does not exist.'));
        return $resultRedirect->setPath('*/*/');
    }
}