<?php
namespace Bulbulatory\Recommendations\Model;
class Recommendation extends \Magento\Framework\Model\AbstractModel implements \Magento\Framework\DataObject\IdentityInterface
{
	const CACHE_TAG = 'bulbulatory_recommendations_recommendation';

	protected $_cacheTag = 'bulbulatory_recommendations_recommendation';

	protected $_eventPrefix = 'bulbulatory_recommendations_recommendation';

	protected function _construct()
	{
		$this->_init('Bulbulatory\Recommendations\Model\ResourceModel\Recommendation');
	}

	public function getIdentities()
	{
		return [self::CACHE_TAG . '_' . $this->getId()];
	}

	public function getDefaultValues()
	{
		$values = [];

		return $values;
	}
}