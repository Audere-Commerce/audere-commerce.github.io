<?php

namespace AudereCommerce\KnowledgeBase\Controller\Adminhtml\Category;

use AudereCommerce\KnowledgeBase\Controller\Adminhtml\Category;

class NewAction extends Category
{

    const ADMIN_RESOURCE = 'AudereCommerce_KnowledgeBase::category_save';

    public function execute()
    {
        $resultRedirect = $this->resultRedirectFactory->create();
        return $resultRedirect->setPath('*/*/edit');
    }
}
