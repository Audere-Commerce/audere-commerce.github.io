<?php

namespace AudereCommerce\KnowledgeBase\Controller\Adminhtml\Post;

use AudereCommerce\KnowledgeBase\Controller\Adminhtml\Post;

class Index extends Post
{

    const ADMIN_RESOURCE = 'AudereCommerce_KnowledgeBase::post';

    public function execute()
    {
        $resultPage = $this->_resultPageFactory->create();

        $resultPage
            ->setActiveMenu('AudereCommerce_KnowledgeBase::post')
            ->addBreadcrumb(__('Manage Post'), __('Manage Post'))
            ->getConfig()->getTitle()->prepend(__('Post'));

        $this->_dataPersistor->clear('post');

        return $resultPage;
    }
}
