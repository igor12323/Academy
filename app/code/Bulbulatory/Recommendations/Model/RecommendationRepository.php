<?php
 
namespace Bulbulatory\Recommendations\Model;
 
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Api\SortOrder;
use Magento\Framework\Exception\NoSuchEntityException;
use Bulbulatory\Recommendations\Api\Data\RecommendationInterface;
use Bulbulatory\Recommendations\Api\Data\RecommendationSearchResultInterface;
use Bulbulatory\Recommendations\Api\Data\RecommendationSearchResultInterfaceFactory;
use Bulbulatory\Recommendations\Api\RecommendationRepositoryInterface;
use Bulbulatory\Recommendations\Model\ResourceModel\Recommendation\Collection;
use Bulbulatory\Recommendations\Model\ResourceModel\Recommendation;
use Magento\Framework\Math\Random;
use Magento\Customer\Api\CustomerRepositoryInterface;
use Magento\Framework\UrlInterface;
use Bulbulatory\Recommendations\Helper\Email;

class RecommendationRepository implements RecommendationRepositoryInterface
{
    /**
     * @var RecommendationFactory
     */
    private $recommendationFactory;
 
    /**
     * @var RecommendationResource
     */
    private $recommendationResource;
 
    /**
     * @var RecommendationSearchResultInterfaceFactory
     */
    private $searchResultFactory;

     /**
     * @var Random
     */

    private $random;

     /**
     * @var CustomerRepositoryInterface
     */
 
     private $customerRepository;

      /**
     * @var UrlInterface
     */
 
    private $urlBuilder;

        /**
     * @var Email
     */
 
    private $email;


    public function __construct(
        Random $random,
        UrlInterface $urlBuilder,
        Email $email,
        CustomerRepositoryInterface $customerRepository,
        RecommendationFactory $recommendationFactory,
        Recommendation $recommendationResource,
        RecommendationSearchResultInterfaceFactory $recommendationSearchResultInterfaceFactory
    ) {
        $this->customerRepository=$customerRepository;
        $this->urlBuilder=$urlBuilder;
        $this->email=$email;
        $this->random=$random;
        $this->recommendationFactory = $recommendationFactory;
        $this->recommendationResource = $recommendationResource;
        $this->searchResultFactory = $recommendationSearchResultInterfaceFactory;
    }
 
    public function getById($id)
    {
        $recommendation = $this->recommendationFactory->create();
        $this->recommendationResource->load($recommendation, $id);
        if (! $recommendation->getRecommendationId()) {
            throw new NoSuchEntityException(__('Unable to find recommendation with ID "%1"', $id));
        }
        return $recommendation;
    }

    public function getByHash($hash)
    {
        $recommendation = $this->recommendationFactory->create();
        $recommendation->getResource()->load($recommendation, $hash, 'hash');

        if (!$recommendation->getRecommendationId()) {
            throw new NoSuchEntityException(__('Unable to find recommendation with hash "%1"', $hash));
        }

        return $recommendation;
    } 

    public function createRecommendation($senderId,$email)
    {
        $recommendation = $this->recommendationFactory->create();
        $recommendation->setCustomerId($senderId);
        $recommendation->setEmail($email);
        $recommendation->setHash($this->random->getUniqueHash());
        $recommendation->setStatus(false);
        $this->recommendationResource->save($recommendation);  
        $this->sendRecommendation($recommendation);
    }

    public function sendRecommendation(RecommendationInterface $recommendation)
    {
        $url = $this->urlBuilder->getUrl(
            'bulbulatory_recommendations/recommendation/confirmRecommendation',
            [
                'hash' => $recommendation->getHash()
            ]
        );
        $customer = $this->customerRepository->getById($recommendation->getCustomerId());
        $templateVars = [
            'recommendationUrl' => $url,
            'customerName' => $customer->getFirstname()
        ];
        $this->email->sendEmail($recommendation->getEmail(), $templateVars);
    }
    
    public function confirmRecommendation($hash)
    {
        $recommendation = $this->getByHash($hash);
        $recommendation->setStatus(true);
        $recommendation->setConfirmationDate(date("Y-m-d H:i:s"));
        $this->recommendationResource->save($recommendation);
    } 

    public function save(RecommendationInterface $recommendation)
    {
        $this->recommendationResource->save($recommendation);
        return $recommendation;
    }

    public function delete(RecommendationInterface $recommendation)
    {
        $this->recommendationResource->delete($recommendation);
    }
 
    public function getList(SearchCriteriaInterface $searchCriteria)
    {
        $collection = $this->collectionFactory->create();
 
        $this->addFiltersToCollection($searchCriteria, $collection);
        $this->addSortOrdersToCollection($searchCriteria, $collection);
        $this->addPagingToCollection($searchCriteria, $collection);
 
        $collection->load();
 
        return $this->buildSearchResult($searchCriteria, $collection);
    }
 
    private function addFiltersToCollection(SearchCriteriaInterface $searchCriteria, Collection $collection)
    {
        foreach ($searchCriteria->getFilterGroups() as $filterGroup) {
            $fields = $conditions = [];
            foreach ($filterGroup->getFilters() as $filter) {
                $fields[] = $filter->getField();
                $conditions[] = [$filter->getConditionType() => $filter->getValue()];
            }
            $collection->addFieldToFilter($fields, $conditions);
        }
    }
 
    private function addSortOrdersToCollection(SearchCriteriaInterface $searchCriteria, Collection $collection)
    {
        foreach ((array) $searchCriteria->getSortOrders() as $sortOrder) {
            $direction = $sortOrder->getDirection() == SortOrder::SORT_ASC ? 'asc' : 'desc';
            $collection->addOrder($sortOrder->getField(), $direction);
        }
    }
 
    private function addPagingToCollection(SearchCriteriaInterface $searchCriteria, Collection $collection)
    {
        $collection->setPageSize($searchCriteria->getPageSize());
        $collection->setCurPage($searchCriteria->getCurrentPage());
    }
 
    private function buildSearchResult(SearchCriteriaInterface $searchCriteria, Collection $collection)
    {
        $searchResults = $this->searchResultFactory->create();
 
        $searchResults->setSearchCriteria($searchCriteria);
        $searchResults->setItems($collection->getItems());
        $searchResults->setTotalCount($collection->getSize());
 
        return $searchResults;
    }
}