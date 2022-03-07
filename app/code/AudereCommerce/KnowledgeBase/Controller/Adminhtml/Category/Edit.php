<?php

namespace AudereCommerce\KnowledgeBase\Controller\Adminhtml\Category;

use AudereCommerce\KnowledgeBase\Controller\Adminhtml\Category;
use Magento\Framework\Exception\NoSuchEntityException;

class Edit extends Category
{

    const ADMIN_RESOURCE = 'AudereCommerce_KnowledgeBase::category_save';

    public function execute()
    {
        $id = $this->getRequest()->getParam('id');

        if (!$id) {
            $model = $this->_categoryFactory->create();
        } else {
            try {
                $model = $this->_categoryRepositoryInterface->getById($id);
            } catch (NoSuchEntityException $e) {
                $this->messageManager->addErrorMessage(__('Category no longer exists.'));
                $resultRedirect = $this->resultRedirectFactory->create();
                return $resultRedirect->setPath('*/*/');
            }
        }

        $this->_registry->register('category', $model);

        $resultPage = $this->_resultPageFactory->create();

        $editType = $id ? __('Edit Category') : __('New Category');

        $resultPage
            ->setActiveMenu('AudereCommerce_KnowledgeBase::category')
            ->addBreadcrumb(__('Manage Category'), __('Manage Category'))
            ->addBreadcrumb($editType, $editType);

        $resultPage->getConfig()->getTitle()->prepend(__('Category'));
        /* $resultPage->getConfig()->getTitle()->prepend(); */

        return $resultPage;
    }
}
