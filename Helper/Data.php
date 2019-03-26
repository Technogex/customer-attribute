<?php
/**
 * Created by Technogex.
 * User: Technogex
 * Date: 3/18/2019
 * Time: 10:49 PM
 */

namespace Technogex\CustomerAttribute\Helper;


class Data extends \Magento\Framework\App\Helper\AbstractHelper
{
    /**
     * Return information array of customer attribute input types
     *
     * @param string $inputType
     * @return array
     */
    public function getAttributeInputTypes($inputType = null)
    {
        $inputTypes = [
            'multiselect' => ['backend_model' => 'Magento\Eav\Model\Entity\Attribute\Backend\ArrayBackend',
                'source_model' => 'Magento\Eav\Model\Entity\Attribute\Source\Table'],
            'boolean' => ['source_model' => 'Magento\Eav\Model\Entity\Attribute\Source\Boolean'],
        ];

        if ($inputType === null) {
            return $inputTypes;
        } else {
            if (isset($inputTypes[$inputType])) {
                return $inputTypes[$inputType];
            }
        }
        return [];
    }

    /**
     * Return default attribute backend model by input type
     *
     * @param string $inputType
     * @return string|null
     */
    public function getAttributeBackendModelByInputType($inputType)
    {
        $inputTypes = $this->getAttributeInputTypes();

        if (!empty($inputTypes[$inputType]['backend_model'])) {
            return $inputTypes[$inputType]['backend_model'];
        }
        return null;
    }

    /**
     * Return default attribute source model by input type
     *
     * @param string $inputType
     * @return string|null
     */
    public function getAttributeSourceModelByInputType($inputType)
    {
        $inputTypes = $this->getAttributeInputTypes();
        if (!empty($inputTypes[$inputType]['source_model'])) {
            return $inputTypes[$inputType]['source_model'];
        }
        return null;
    }
}
