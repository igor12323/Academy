<?php
namespace Bulbulatory\Recommendations\Ui\Component\Listing\Column;

use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Ui\Component\Listing\Columns\Column;
use \Magento\Customer\Api\CustomerRepositoryInterface;

class RecommenderEmail extends Column
{
    protected $customerRepositoryInterface;

    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        CustomerRepositoryInterface $customerRepositoryInterface,
        array $components = [],
        array $data = []
    ) {
        parent::__construct($context, $uiComponentFactory, $components, $data);
        $this->_customerRepositoryInterface = $customerRepositoryInterface;
    }

public function prepareDataSource(array $dataSource)
{
    if (isset($dataSource['data']['items'])) {
        foreach ($dataSource['data']['items'] as &$item) {
            if ($item['customer_id']) {
                $recommenderId = $item['customer_id'];
                $recommender = $this->_customerRepositoryInterface->getById($recommenderId);
                $item['customer_id'] = $recommender->getEmail();
            } else {
                $item['customer_id'] = '';
            }
        }
    }
    return $dataSource;
}
} 