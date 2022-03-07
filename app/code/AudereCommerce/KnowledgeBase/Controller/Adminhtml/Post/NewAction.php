<?php

namespace AudereCommerce\KnowledgeBase\Controller\Adminhtml\Post;

use AudereCommerce\KnowledgeBase\Controller\Adminhtml\Post;

class NewAction extends Post
{

    const ADMIN_RESOURCE = 'AudereCommerce_KnowledgeBase::post_save';

    public function execute()
    {
        $resultRedirect = $this->resultRedirectFactory->create();
        return $resultRedirect->setPath('*/*/edit');
    }
}
