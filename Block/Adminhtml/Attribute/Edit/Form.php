<?php
/**
 * Created by Technogex.
 * User: Technogex
 * Date: 3/17/2019
 * Time: 10:26 AM
 */

namespace Technogex\CustomerAttribute\Block\Adminhtml\Attribute\Edit;


use Magento\Backend\Block\Widget\Form\Generic;
use Magento\Framework\Data\Form as DataForm;

class Form extends Generic
{
    /**
     * @return $this
     */
    protected function _prepareForm()
    {
        /** @var DataForm $form */
        $form = $this->_formFactory->create(
            ['data' => ['id' => 'edit_form', 'action' => $this->getData('action'), 'method' => 'post']]
        );
        $form->setUseContainer(true);
        $this->setForm($form);
        return parent::_prepareForm();
    }
}