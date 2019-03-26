<?php
/**
 * User: Technogex
 * Date: 3/16/2019
 * Time: 5:28 PM
 */
namespace Technogex\CustomerAttribute\Controller\Adminhtml\Attribute;

class Index extends  \Magento\Backend\App\Action
{
    /**
     * @var \Magento\Framework\View\Result\PageFactory
     */
    protected $resultPageFactory;

    /**
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory
    )
    {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
    }


    /**
     * Index action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('Technogex_CustomerAttribute::customer_attributes');
        $resultPage->addBreadcrumb(__('Customer Attribute'), __('CustomerAttribute'));
        $resultPage->addBreadcrumb(__('Manage Customer Attribute'), __('Customer Attributes'));
        $resultPage->getConfig()->getTitle()->prepend(__('Customer Attributes'));
        return $resultPage;
    }

    /*
     * Is user allowed to view manage customer attribute grid.
     *
     * @return bool
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Technogex_CustomerAttribute::customer_attributes');
    }
}