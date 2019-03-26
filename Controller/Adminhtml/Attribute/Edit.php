<?php
/**
 * Created by Technogex.
 * User: Technogex
 * Date: 3/17/2019
 * Time: 9:09 AM
 */

namespace Technogex\CustomerAttribute\Controller\Adminhtml\Attribute;


class Edit extends \Magento\Backend\App\Action
{
    /**
     * Core registry
     *
     * @var \Magento\Framework\Registry
     */
    protected $coreRegistry = null;

    /**
     * @var \Magento\Framework\View\Result\PageFactory
     */
    protected $resultPageFactory;

    /**
     * @var string
     */
    protected $_entityTypeId;

    /**
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
     * @param \Magento\Framework\Registry $registry
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        \Magento\Framework\Registry $registry
    ) {
        $this->resultPageFactory = $resultPageFactory;
        $this->coreRegistry = $registry;
        parent::__construct($context);
    }

    /**
     * {@inheritdoc}
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Technogex_CustomerAttribute::save');
    }

    /**
     * Init actions
     *
     * @return \Magento\Backend\Model\View\Result\Page
     */
    protected function _initAction()
    {
        // load layout, set active menu and breadcrumbs
        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('Clarion_CustomerAttribute::customer_attributes')
            ->addBreadcrumb(__('Customer Attributes'), __('Customer Attributes'))
            ->addBreadcrumb(__('Manage Customer Attributes'), __('Manage Customer Attributes'));
        return $resultPage;
    }

    /**
     * @return \Magento\Framework\Controller\ResultInterface
     * @SuppressWarnings(PHPMD.NPathComplexity)
     */
    public function execute()
    {
        // 1. Get ID and create model
       $id = $this->getRequest()->getParam('attribute_id');

        /** @var $model \Magento\Catalog\Model\ResourceModel\Eav\Attribute */
        $model = $this->_objectManager->create(
            'Magento\Customer\Model\Attribute'
        )->setEntityTypeId(
            $this->_entityTypeId
        );

        // 2. Initial checking
        if ($id) {
            $model->load($id);

            if (!$model->getId()) {

                $this->messageManager->addErrorMessage(__('This block no longer exists.'));
                /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
                $resultRedirect = $this->resultRedirectFactory->create();
                return $resultRedirect->setPath('customerattribute/*/');
            }

            // 3. Check entity type
            if ($model->getEntityTypeId() != $this->_entityTypeId) {
                $this->messageManager->addErrorMessage(__('This attribute cannot be edited.'));
                /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
                $resultRedirect = $this->resultRedirectFactory->create();
                return $resultRedirect->setPath('customerattribute/*/');
            }
        }

        // If some error occur, set data to session which is entered by users
        $data = $this->_objectManager->get('Magento\Backend\Model\Session')->getAttributeData(true);
        if (!empty($data)) {
            $model->addData($data);
        }
        $attributeData = $this->getRequest()->getParam('attribute');
        if (!empty($attributeData) && $id === null) {
            $model->addData($attributeData);
        }

        $this->coreRegistry->register('entity_attribute', $model);

        $item = $id ? __('Edit Customer Attribute') : __('New Customer Attribute');

        $resultPage = $this->createActionPage($item);
        $resultPage->getConfig()->getTitle()->prepend($id ? $model->getName() : __('New Customer Attribute'));
        $resultPage->getLayout()
            ->getBlock('attribute_edit_js');
        return $resultPage;
    }

    /**
     * @param \Magento\Framework\Phrase|null $title
     * @return \Magento\Backend\Model\View\Result\Page
     */
    protected function createActionPage($title = null)
    {
        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        $resultPage = $this->resultPageFactory->create();
        $resultPage->addBreadcrumb(__('Customer'), __('Customer'))
            ->addBreadcrumb(__('Manage Customer Attributes'), __('Manage Customer Attributes'))
            ->setActiveMenu('Technogex_CustomerAttribute::customer_attributes');
        if (!empty($title)) {
            $resultPage->addBreadcrumb($title, $title);
        }
        $resultPage->getConfig()->getTitle()->prepend(__('Customer Attributes'));
        return $resultPage;
    }

    /**
     * Dispatch request
     *
     * @param \Magento\Framework\App\RequestInterface $request
     * @return \Magento\Framework\App\ResponseInterface
     */
    public function dispatch(\Magento\Framework\App\RequestInterface $request)
    {

        $this->_entityTypeId = $this->_objectManager->create(
            'Magento\Eav\Model\Entity'
        )->setType(
            \Magento\Customer\Model\Customer::ENTITY
        )->getTypeId();
        return parent::dispatch($request);
    }

    /**
     * Generate code from label
     *
     * @param string $label
     * @throws \Exception
     * @return string
     */
    protected function generateCode($label)
    {
        $code = substr(
            preg_replace(
                '/[^a-z_0-9]/',
                '_',
                $this->_objectManager->create('Magento\Catalog\Model\Product\Url')->formatUrlKey($label)
            ),
            0,
            30
        );
        $validatorAttrCode = new \Zend_Validate_Regex(['pattern' => '/^[a-z][a-z_0-9]{0,29}[a-z0-9]$/']);
        if (!$validatorAttrCode->isValid($code)) {
            $code = 'attr_' . ($code ?: substr(md5(time()), 0, 8));
        }
        return $code;
    }
}