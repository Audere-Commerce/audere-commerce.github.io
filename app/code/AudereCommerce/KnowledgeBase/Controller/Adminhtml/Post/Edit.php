<?php

namespace AudereCommerce\KnowledgeBase\Controller\Adminhtml\Post;

use AudereCommerce\KnowledgeBase\Controller\Adminhtml\Post;
use Magento\Framework\Exception\NoSuchEntityException;

class Edit extends Post
{

    const ADMIN_RESOURCE = 'AudereCommerce_KnowledgeBase::post_save';

    public function execute()
    {
        $id = $this->getRequest()->getParam('id');

        if (!$id) {
            $model = $this->_postFactory->create();
        } else {
            try {
                $model = $this->_postRepositoryInterface->getById($id);
            } catch (NoSuchEntityException $e) {
                $this->messageManager->addErrorMessage(__('Post no longer exists.'));
                $resultRedirect = $this->resultRedirectFactory->create();
                return $resultRedirect->setPath('*/*/');
            }
        }

        $this->_registry->register('post', $model);

        $resultPage = $this->_resultPageFactory->create();

        $editType = $id ? __('Edit Post') : __('New Post');

        $resultPage
            ->setActiveMenu('AudereCommerce_KnowledgeBase::post')
            ->addBreadcrumb(__('Manage Post'), __('Manage Post'))
            ->addBreadcrumb($editType, $editType);

        $resultPage->getConfig()->getTitle()->prepend(__('Post'));
        /* $resultPage->getConfig()->getTitle()->prepend(); */

        return $resultPage;
    }
}
