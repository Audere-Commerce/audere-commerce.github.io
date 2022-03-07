<?php

namespace AudereCommerce\KnowledgeBase\Controller\Adminhtml\Category;

use AudereCommerce\KnowledgeBase\Controller\Adminhtml\Category;

class Delete extends Category
{

    const ADMIN_RESOURCE = 'AudereCommerce_KnowledgeBase::category_delete';

    public function execute()
    {
        $resultRedirect = $this->resultRedirectFactory->create();

        if ($id = $this->getRequest()->getParam('id')) {
            try {
                $categoryRepository = $this->_categoryRepositoryInterface->getById($id);
                $this->_categoryRepositoryInterface->delete($categoryRepository);
                $this->messageManager->addSuccessMessage(__('The Category has been deleted.'));
            } catch (\Exception $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
            }
        }

        return $resultRedirect->setPath('*/*/');
    }
}
