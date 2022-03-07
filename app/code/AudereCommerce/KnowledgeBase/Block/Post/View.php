<?php

namespace AudereCommerce\KnowledgeBase\Block\Post;

use Magento\Framework\View\Element\Template;
use Magento\Store\Model\ScopeInterface;
use Magento\Framework\Registry;

class View extends \Magento\Framework\View\Element\Template
{
    /**
     * @var Registry
     */
    protected $_registry;

    public function __construct(
        Template\Context $context,
        Registry $registry,
        array $data = []
    )
    {
        parent::__construct($context, $data);
        $this->_registry = $registry;
    }

    protected function _prepareLayout()
    {
        $post = $this->getPost();
        /* @var $post \AudereCommerce\KnowledgeBase\Api\Data\PostInterface */

        if ($post) {
            $this->_addBreadcrumbs($post->getTitle(), 'post');
            $this->pageConfig->addBodyClass('post-' . $post->getUrlKey());
            $this->pageConfig->getTitle()->set($post->getTitle());

            $pageMainTitle = $this->getLayout()->getBlock('page.main.title');
            if ($pageMainTitle) {
                $pageMainTitle->setPageTitle(
                    $this->escapeHtml($post->getTitle())
                );
            }
        }

        return parent::_prepareLayout();
    }

    protected function _addBreadcrumbs($title = null, $key = null)
    {
        if ($breadcrumbsBlock = $this->getLayout()->getBlock('breadcrumbs')) {
            $breadcrumbsBlock->addCrumb(
                'home',
                [
                    'label' => __('Home'),
                    'title' => __('Go to Home Page'),
                    'link' => $this->_storeManager->getStore()->getBaseUrl()
                ]
            );
            $breadcrumbsBlock->addCrumb(
                'knowledgebase',
                [
                    'label' => __('KnowledgeBase'),
                    'title' => __('View all knowledgebase'),
                    'link' => $this->_storeManager->getStore()->getBaseUrl() . 'knowledgebase'
                ]
            );

            $breadcrumbsBlock->addCrumb($key, [
                'label' => $title ,
                'title' => $title
            ]);
        }
    }

    public function getPost()
    {
        if (!$this->hasData('post')) {
            $this->setData(
                'post',
                $this->_registry->registry('post')
            );
        }
        return $this->getData('post');
    }
}
