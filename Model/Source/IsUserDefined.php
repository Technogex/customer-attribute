<?php
/**
 * User: TechnoGex
 * Date: 3/17/2019
 * Time: 8:59 AM
 */

namespace Technogex\CustomerAttribute\Model\Source;


class IsUserDefined implements \Magento\Framework\Data\OptionSourceInterface
{
    /**
     * Get options
     *
     * @return array
     */
    public function toOptionArray()
    {
        return [
            ['value' => 0, 'label'=>'Yes'],
            'value' => 1, 'label'=>'No'
        ];
    }

}