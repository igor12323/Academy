<?php
namespace Bulbulatory\Recommendations\Model\ResourceModel\Recommendation;
class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
	protected $_idFieldName = 'recommendation_id';
	protected $_eventPrefix = 'bulbulatory_recommendations_recommendation';
	protected $_eventObject = 'bulbulatory_recommendations';

	/**
	 * Define resource model
	 *
	 * @return void
	 */
	protected function _construct()
	{
		$this->_init('Bulbulatory\Recommendations\Model\Recommendation', 'Bulbulatory\Recommendations\Model\ResourceModel\Recommendation');
	}

}