<?php
namespace Bulbulatory\Recommendations\Model\ResourceModel\Recommendation;

use Bulbulatory\Recommendations\Model\Recommendation;
use \Bulbulatory\Recommendations\Model\ResourceModel\Recommendation as RecommendationResource;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
	protected $_idFieldName = 'recommendation_id';
	protected $_eventPrefix = 'bulbulatory_recommendations_recommendation_collection';
	protected $_eventObject = 'recommendation_collection';

	/**
	 * Define resource model
	 *
	 * @return void
	 */
	protected function _construct()
	{
		$this->_init(Recommendation::class, RecommendationResource::class);
	}

}