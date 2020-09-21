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
 
    public function __construct(
        RecommendationFactory $recommendationFactory,
        Recommendation $recommendationResource,
        RecommendationSearchResultInterfaceFactory $recommendationSearchResultInterfaceFactory
    ) {
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