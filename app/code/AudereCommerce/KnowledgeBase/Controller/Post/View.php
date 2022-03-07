<?php

namespace AudereCommerce\KnowledgeBase\Controller\Post;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\Registry;
use AudereCommerce\KnowledgeBase\Model\ResourceModel\Post\CollectionFactory as PostCollectionFactory;

class View extends Action
{
    /**
     * @var Registry
     */
    protected $_registry;

    /**
     * @var PostCollectionFactory
     */
    protected $_postCollectionFactory;

    public function __construct(
        Context $context,
        Registry $registry,
        PostCollectionFactory $postCollectionFactory
    )
    {
        parent::__construct($context);
        $this->_registry = $registry;
        $this->_postCollectionFactory = $postCollectionFactory;
    }

    public function execute()
    {
        $post = $this->_postCollectionFactory->create();

        if ($id = $this->getRequest()->getParam('id')) {
            $post->load($id);
        }

        $params = $this->getRequest()->getParams();

        if ($key = array_keys($params)[0]) {
            if (is_string($key)) {
                $post = $this->_postCollectionFactory->create()
                    ->addFieldToSelect('enabled', true)
                    ->addFieldToFilter('url_key', $key)
                    ->addFieldToSelect('*');
            }
        }

        if ($post = $post->getFirstItem()) {
            if (!$post->getEnabled()) {
                return $this->_redirect('knowledgebase');
            }

            $this->_registry->register('post', $post);

            $this->_view->loadLayout();
            $this->_view->renderLayout();
        } else {
            return $this->_redirect($this->_redirect->getRefererUrl());
        }
    }
}
