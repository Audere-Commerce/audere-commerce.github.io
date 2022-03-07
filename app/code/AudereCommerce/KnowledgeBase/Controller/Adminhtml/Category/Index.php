<?php

namespace AudereCommerce\KnowledgeBase\Controller\Adminhtml\Category;

use AudereCommerce\KnowledgeBase\Controller\Adminhtml\Category;

class Index extends Category
{

    const ADMIN_RESOURCE = 'AudereCommerce_KnowledgeBase::category';

    public function execute()
    {
        $resultPage = $this->_resultPageFactory->create();

        $resultPage
            ->setActiveMenu('AudereCommerce_KnowledgeBase::category')
            ->addBreadcrumb(__('Manage Category'), __('Manage Category'))
            ->getConfig()->getTitle()->prepend(__('Category'));

        $this->_dataPersistor->clear('category');

        return $resultPage;
    }
}
