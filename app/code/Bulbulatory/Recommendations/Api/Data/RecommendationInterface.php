<?php
 
namespace Bulbulatory\Recommendations\Api\Data;
 
use Magento\Framework\Api\ExtensibleDataInterface;
 
interface RecommendationInterface extends ExtensibleDataInterface
{
    /**
     * @return int
     */
    public function getRecommendationId();
 
    /**
     * @param int $id
     * @return void
     */
    public function setRecommendationId($id);
 
    /**
     * @return int
     */
    public function getCustomerId();
 
    /**
     * @param int $id
     * @return void
     */
    public function setCustomerId($id);
 
    /**
     * @return string
     */
    public function getEmail();
 
    /**
     * @param string $email
     * @return void
     */
    public function setEmail($email);

    /**
     * @return string
     */
    public function getHash();
 
    /**
     * @param string $hash
     * @return void
     */
    public function setHash($hash);

    /**
     * @return bool
     */
    public function getStatus();
 
    /**
     * @param bool $status
     * @return void
     */
    public function setStatus($status);

    /**
     * @return string
     */
    public function getCreationDate();
 
    /**
     * @param string $creation_date
     * @return void
     */
    public function setCreationDate($creation_date);

    /**
     * @return string|null
     */
    public function getConfirmationDate();
 
    /**
     * @param string $confirmation_date
     * @return void
     */
    public function setConfirmationDate($confirmation_date);
}