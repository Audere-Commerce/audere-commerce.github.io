<?php

namespace AudereCommerce\KnowledgeBase\Controller\Adminhtml\Post;

use AudereCommerce\KnowledgeBase\Controller\Adminhtml\Post;

class Delete extends Post
{

    const ADMIN_RESOURCE = 'AudereCommerce_KnowledgeBase::post_delete';

    public function execute()
    {
        $resultRedirect = $this->resultRedirectFactory->create();

        if ($id = $this->getRequest()->getParam('id')) {
            try {
                $postRepository = $this->_postRepositoryInterface->getById($id);
                $this->_postRepositoryInterface->delete($postRepository);
                $this->messageManager->addSuccessMessage(__('The Post has been deleted.'));
            } catch (\Exception $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
            }
        }

        return $resultRedirect->setPath('*/*/');
    }
}
