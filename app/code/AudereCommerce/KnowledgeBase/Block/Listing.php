<?php

namespace AudereCommerce\KnowledgeBase\Block;

use Magento\Framework\View\Element\Template;
use AudereCommerce\KnowledgeBase\Model\ResourceModel\Post\CollectionFactory as PostCollectionFactory;
use AudereCommerce\KnowledgeBase\Api\Data\PostInterface;

class Listing extends Template
{
    /**
     * @var PostCollectionFactory
     */
    protected $postCollectionFactory;

    public function __construct(
        Template\Context $context,
        PostCollectionFactory $postCollectionFactory,
        array $data = []
    )
    {
        parent::__construct($context, $data);
        $this->postCollectionFactory = $postCollectionFactory;
    }

    protected function _prepareLayout()
    {
        parent::_prepareLayout();

        if (count($this->getAllKnowledgeBase())) {
            $pager = $this->getLayout()->createBlock(
                'Magento\Theme\Block\Html\Pager',
                'knowledgebase.pager'
            )->setAvailableLimit(array(6=>6))->setShowPerPage(true)->setCollection(
                $this->getAllKnowledgeBase()
            );

            $this->setChild('pager', $pager);
            $this->getAllKnowledgeBase()->load();
        }

        return $this;
    }

    public function getPagerHtml()
    {
        return $this->getChildHtml('pager');
    }

    // Order by newest first
    // Ability to filter by category
    // Pagination
    // Only active knowledgebase
    public function getAllKnowledgeBase()
    {
        $page = $this->getRequest()->getParam('p') ? $this->getRequest()->getParam('p') : 1;
        $pageSize = $this->getRequest()->getParam('limit') ? $this->getRequest()->getParam('limit') : 6;
        $category = $this->getRequest()->getParam('category') ? $this->getRequest()->getParam('category') : false;

        $knowledgebaseCollection = $this->postCollectionFactory->create()
            ->addFieldToFilter('enabled', true)
            ->setOrder('created_at', 'ASC')
            ->setPageSize($pageSize)
            ->setCurPage($page);

        if ($category) {
            $knowledgebaseCollection->addFieldToFilter('category', $category);
        }

        return $knowledgebaseCollection;
    }

    public function getPostUrl(PostInterface $post)
    {
        if ($key = $post->getUrlKey()) {
            return $this->_urlBuilder->getUrl('knowledgebase/post/view') . $key;
        }

        return $this->_urlBuilder->getUrl('knowledgebase/post/view', array('id' => $this->getId()));
    }

    public function getPostImage($image, PostInterface $post)
    {
        $mediaUrl = $this->_storeManager->getStore()->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA);
        $imageKey = $post->getData($image);

        if ($imageKey) {
            return $mediaUrl . 'knowledgebase/post/' . $imageKey;
        }

        return false;
    }

    public function getListingImage(PostInterface $post)
    {
        if ($post->getListingImage()) {
            return $this->getPostImage('listing_image', $post);
        }

        return $this->getPostImage('main_image', $post);
    }
}
