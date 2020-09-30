<?php
 
namespace Bulbulatory\Recommendations\Api;
 
use Magento\Framework\Api\SearchCriteriaInterface;
use Bulbulatory\Recommendations\Api\Data\RecommendationInterface;
 
interface RecommendationRepositoryInterface
{
    /**
     * @param int $id
     * @return \Bulbulatory\Recommendations\Api\Data\RecommendationInterface
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getById($id);
 
    /**
     * @param \Bulbulatory\Recommendations\Api\Data\RecommendationInterface $recommendation
     * @return \Bulbulatory\Recommendations\Api\Data\RecommendationInterface
     */
    public function save(RecommendationInterface $recommendation);
 
    /**
     * @param \Bulbulatory\Recommendations\Api\Data\RecommendationInterface $recommendation
     * @return void
     */
    public function delete(RecommendationInterface $recommendation);
 
    /**
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \Bulbulatory\Recommendations\Api\Data\RecommendationSearchResultInterface
     */
    public function getList(SearchCriteriaInterface $searchCriteria);

    public function createRecommendation($senderId,$email);

    public function sendRecommendation(RecommendationInterface $recommendation);

    public function confirmRecommendation($hash);
}