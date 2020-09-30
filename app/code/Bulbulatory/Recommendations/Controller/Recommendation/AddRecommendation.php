<?php
namespace Bulbulatory\Recommendations\Controller\Recommendation;

use Magento\Framework\Controller\ResultFactory;
use Bulbulatory\Recommendations\Api\RecommendationRepositoryInterface;
use Magento\Customer\Model\Session;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Action\Action;


class AddRecommendation extends Action
{
    protected $recommendationRepository;
    protected $sender;
    protected $recommendation;
    

    public function __construct(
        Context $context,
        RecommendationRepositoryInterface $recommendationRepository,
        Session $sender
    ) {
        parent::__construct($context);
        $this->recommendationRepository = $recommendationRepository;
        $this->sender = $sender;
    }

	public function execute()
	{
        $post = (array)$this->getRequest()->getPost();
        if (!empty($post)) {
            $email =$post['recommendation_email'];
            try {
                $senderId=$this->sender->getId();
                $this->recommendationRepository->createRecommendation($senderId,$email);
                $this->messageManager->addSuccessMessage(__('Recommendation sent.'));
                } catch (Exception $e) {
                    $this->messageManager->addErrorMessage(__('Cannot send recommendation.'));
                }
            $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
            $resultRedirect->setUrl('/bulbulatory_recommendations/recommendation/index');
            return $resultRedirect;
        }
	}
}