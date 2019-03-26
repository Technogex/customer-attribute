<?php
/**
 * Customer attribute add/edit form main tab
 * User: Technogex
 * Date: 3/17/2019
 * Time: 9:42 AM
 */

namespace Technogex\CustomerAttribute\Block\Adminhtml\Attribute\Edit\Tab;

use Magento\Eav\Block\Adminhtml\Attribute\Edit\Main\AbstractMain;

class Main extends AbstractMain
{
    /**
     * Adding Customer Attribute form elements for editing attribute
     *
     * @return $this
     * @SuppressWarnings(PHPMD.UnusedLocalVariable)
     */
    protected function _prepareForm()
    {
        parent::_prepareForm();
        /** @var \Magento\Catalog\Model\ResourceModel\Eav\Attribute $attributeObject */
        $attributeObject = $this->getAttributeObject();
        /* @var $form \Magento\Framework\Data\Form */
        $form = $this->getForm();
        /* @var $fieldset \Magento\Framework\Data\Form\Element\Fieldset */
        $fieldset = $form->getElement('base_fieldset');
        $fiedsToRemove = ['attribute_code', 'is_unique', 'frontend_class'];

        foreach ($fieldset->getElements() as $element) {
            /** @var \Magento\Framework\Data\Form\AbstractForm $element  */
            if (substr($element->getId(), 0, strlen('default_value')) == 'default_value') {
                $fiedsToRemove[] = $element->getId();
            }
        }
        foreach ($fiedsToRemove as $id) {
            $fieldset->removeField($id);
        }

        $frontendInputElm = $form->getElement('frontend_input');
        $frontendInputValues = $frontendInputElm->getValues();
        $frontendInputElm->setValues($frontendInputValues);
        $frontendInputElm->setLabel('Input Type');
        return $this;
    }

}