<?php

namespace Bulbulatory\Recommendations\Ui\Component\Listing\Column;

class Status implements \Magento\Framework\Option\ArrayInterface
{
    public function toOptionArray()
    {
        return [
            ['value' => 0, 'label' => __('Unconfirmed')],
            ['value' => 1, 'label' => __('Confirmed')]
        ];
    }
}