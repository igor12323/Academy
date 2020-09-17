<?php
 
namespace Bulbulatory\Recommendations\Api\Data;
 
use Magento\Framework\Api\SearchResultsInterface;
 
interface RecommendationSearchResultInterface extends SearchResultsInterface
{
    /**
     * @return \Bulbulatory\Recommendations\Api\Data\RecommendationInterface[]
     */
    public function getItems();
 
    /**
     * @param \Bulbulatory\Recommendations\Api\Data\RecommendationInterface[] $items
     * @return void
     */
    public function setItems(array $items);
}