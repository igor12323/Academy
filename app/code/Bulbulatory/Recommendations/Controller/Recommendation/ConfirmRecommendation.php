<?php
namespace Bulbulatory\Recommendations\Controller\Recommendation;

use Bulbulatory\Recommendations\Api\Data\RecommendationInterface;
use Bulbulatory\Recommendations\Api\RecommendationRepositoryInterface;
use Magento\Framework\Controller\ResultFactory;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Action\Action;

class ConfirmRecommendation extends Action
{
    protected $recommendation;
    protected $recommendationRepository;

    public function __construct(
        Context $context,
        RecommendationRepositoryInterface $recommendationRepository,
        RecommendationInterface $recommendation
    ) {
        parent::__construct($context);
        $this->recommendationRepository = $recommendationRepository;
        $this->recommendation = $recommendation;
    }

    public function execute()
    {
        try {
            $hash = $this->getRequest()->getParam('hash');
            $this->recommendationRepository->confirmRecommendation($hash);
            $this->messageManager->addSuccessMessage(__('Recommendation confirmed.'));
        } catch (NoSuchEntityException $e) {
            $hash = $this->getRequest()->getParam('hash');
            $this->messageManager->addErrorMessage(__('Recommendation does not exist.'));
        } catch (Exception $e) {
            $this->messageManager->addErrorMessage(__('Cannot confirm recommendation.'));
        }
        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        $resultRedirect->setUrl('/');
        return $resultRedirect;
    }
}