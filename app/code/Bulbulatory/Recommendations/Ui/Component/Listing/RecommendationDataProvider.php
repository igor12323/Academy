<?php

namespace Bulbulatory\Recommendations\Ui\Component\Listing;

class RecommendationDataProvider extends \Magento\Framework\View\Element\UiComponent\DataProvider\SearchResult
{
    protected function _initSelect()
    {
        parent::_initSelect();

        $this->getSelect()->joinLeft(
            [
                'customersTable' => $this->getTable('customer_entity')
            ], 
            'main_table.customer_id = customersTable.entity_id', 
            [
                'email as customer_email'
            ]
        );
        $this->addFilterToMap('customer_email', 'customersTable.email');
        return $this;
    }
} 