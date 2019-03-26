<?php
/**
 * Customer attribute delete controller
 */

namespace Technogex\CustomerAttribute\Controller\Adminhtml\Attribute;


class Delete extends \Magento\Backend\App\Action
{

    /**
     * Authorization level of a basic admin session
     *
     * @see _isAllowed()
     */
    const ADMIN_RESOURCE = 'Technogex_CustomerAttribute::attribute_delete';

    
    /**
     * Delete action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $id = $this->getRequest()->getParam('attribute_id');
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        if ($id) {
            try {
                $model = $this->_objectManager->create('Magento\Customer\Model\Attribute');
                $model->load($id);
                $model->delete();
                $this->messageManager->addSuccessMessage(__('The attribute has been deleted.'));
                return $resultRedirect->setPath('*/*/');
            } catch (\Exception $e) {
                $this->messageManager->addErrorMessage(__($e->getMessage()));

                return $resultRedirect->setPath('*/*/edit', ['id' => $id]);
            }
        }
        $this->messageManager->addErrorMessage(__('We can\'t find a attribute to delete.'));
        return $resultRedirect->setPath('*/*/');
    }
}