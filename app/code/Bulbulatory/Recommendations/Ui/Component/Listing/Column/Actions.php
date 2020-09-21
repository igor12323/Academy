<?php

namespace Bulbulatory\Recommendations\Ui\Component\Listing\Column;

use Magento\Framework\UrlInterface;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Ui\Component\Listing\Columns\Column;

/**
 * Class Actions
 */
class Actions extends Column
{
    protected $urlBuilder;
    /**
     * Prepare Data Source
     *
     * @param array $dataSource
     * @return array
     */

    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        UrlInterface $urlBuilder,
        array $components = [],
        array $data = []
    ) {
        $this->urlBuilder = $urlBuilder;
        parent::__construct($context, $uiComponentFactory, $components, $data);
    }

    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as & $item) {
                $item[$this->getData('name')] = [
                    'delete' => [
                        'href' => $this->urlBuilder->getUrl(
                            'bulbulatory_recommendations/recommendation/delete',
                            ['recommendation_id' => $item['recommendation_id']]),
                        'label' => __('Delete')
                    ],
                ];
            }
        }
        return $dataSource;
    }
}