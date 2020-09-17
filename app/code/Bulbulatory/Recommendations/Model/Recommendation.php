<?php
namespace Bulbulatory\Recommendations\Model;

use Magento\Framework\Model\AbstractExtensibleModel;
use Bulbulatory\Recommendations\Api\Data\RecommendationInterface;

class Recommendation extends AbstractExtensibleModel implements RecommendationInterface
{
	const ID = 'recommendation_id';
    const CUSTOMER_ID = 'customer_id';
	const EMAIL = 'email_address';
	const HASH = 'hash';
	const STATUS = 'status';
	const CREATION_DATE = 'creation_date';
	const CONFIRMATION_DATE = 'confirmation_date';
	
	const CACHE_TAG = 'bulbulatory_recommendations_recommendation';

	protected $_cacheTag = 'bulbulatory_recommendations_recommendation';

	protected $_eventPrefix = 'bulbulatory_recommendations_recommendation';

	protected $_eventObject = 'recommendation';

	protected function _construct()
	{
		$this->_init('Bulbulatory\Recommendations\Model\ResourceModel\Recommendation');
	}

	public function getIdentities()
	{
		return [self::CACHE_TAG . '_' . $this->getRecommendationId()];
	}

	public function getDefaultValues()
	{
		return [];
	}

	public function getRecommendationId()
	{
		return $this->_getData(self::ID);
	}

	public function setRecommendationId($id)
	{
		$this->setData(self::ID, $id);
	}

	public function getCustomerId()
	{
		return $this->_getData(self::customer_ID);
	}

	public function setCustomerId($customer_id)
	{
		$this->setData(self::CUSTOMER_ID, $customer_id);
	}

	public function getEmail()
	{
		return $this->_getData(self::EMAIL);
	}

	public function setEmail($email)
	{
		$this->setData(self::EMAIL, $email);
	}

	public function getHash()
	{
		return $this->_getData(self::HASH);
	}

	public function setHash($hash)
	{
		$this->setData(self::HASH, $hash);
	}

	public function getStatus()
	{
		return $this->_getData(self::STATUS);
	}

	public function setStatus($status)
	{
		$this->setData(self::STATUS, $status);
	}

	public function getCreationDate()
	{
		return $this->_getData(self::CREATION_DATE);
	}

	public function setCreationDate($creation_date)
	{
		$this->setData(self::CREATION_DATE, $creation_date);
	}

	public function getConfirmationDate()
	{
		return $this->_getData(self::CONFIRMATION_DATE);
	}

	public function setConfirmationDate($confirmation_date)
	{
		$this->setData(self::CONFIRMATION_DATE, $confirmation_date);
	}
}