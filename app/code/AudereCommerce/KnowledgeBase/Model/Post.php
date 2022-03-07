<?php

namespace AudereCommerce\KnowledgeBase\Model;

use \AudereCommerce\KnowledgeBase\Api\Data\CategoryInterface;
use \Magento\Framework\Model\AbstractModel;
use AudereCommerce\KnowledgeBase\Api\Data\PostInterface;
use AudereCommerce\KnowledgeBase\Api\PostManagementInterface;

class Post extends AbstractModel implements PostInterface
{
    const ID = 'id';

    const TITLE = 'title';

    const LISTING_IMAGE = 'listing_image';

    const MAIN_IMAGE = 'main_image';

    const SHORT_DESCRIPTION = 'short_description';

    const CONTENT = 'content';

    const META_TITLE = 'meta_title';

    const META_DESCRIPTION = 'meta_description';

    const META_KEYWORDS = 'meta_keywords';

    const ENABLED = 'enabled';

    const SORT_ORDER = 'sort_order';

    const CREATED_AT = 'created_at';

    const UPDATED_AT = 'updated_at';

    const CATEGORY = 'category';

    const URL_KEY = 'url_key';

    /**
     * @var PostManagementInterface
     */
    protected $_postManagementInterface;

    /**
     * @param PostManagementInterface $postManagementInterface
     * @param \Magento\Framework\Model\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param \Magento\Framework\Model\ResourceModel\AbstractResource $resource
     * @param \Magento\Framework\Data\Collection\AbstractDb $resourceCollection
     * @param array $data
     */
    public function __construct(PostManagementInterface $postManagementInterface, \Magento\Framework\Model\Context $context, \Magento\Framework\Registry $registry, \Magento\Framework\Model\ResourceModel\AbstractResource $resource = null, \Magento\Framework\Data\Collection\AbstractDb $resourceCollection = null, array $data = array())
    {
        $this->_postManagementInterface = $postManagementInterface;
        parent::__construct($context, $registry, $resource, $resourceCollection, $data);
    }

    public function _construct()
    {
        $this->_init('AudereCommerce\KnowledgeBase\Model\ResourceModel\Post');
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->getData(self::ID);
    }

    /**
     * @param int $id
     * @return $this
     */
    public function setId($id)
    {
        $this->setData(self::ID, (int)$id);
        return $this;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->getData(self::TITLE);
    }

    /**
     * @param string $title
     * @return $this
     */
    public function setTitle($title)
    {
        $this->setData(self::TITLE, (string)$title);
        return $this;
    }

    /**
     * @return string
     */
    public function getListingImage()
    {
        return $this->getData(self::LISTING_IMAGE);
    }

    /**
     * @param string $title
     * @return $this
     */
    public function setListingImage($listingImage)
    {
        $this->setData(self::LISTING_IMAGE, (string)$listingImage);
        return $this;
    }

    /**
     * @return string
     */
    public function getMainImage()
    {
        return $this->getData(self::MAIN_IMAGE);
    }

    /**
     * @param string $mainImage
     * @return $this
     */
    public function setMainImage($mainImage)
    {
        $this->setData(self::MAIN_IMAGE, (string)$mainImage);
        return $this;
    }

    /**
     * @return string
     */
    public function getShortDescription()
    {
        return $this->getData(self::SHORT_DESCRIPTION);
    }

    /**
     * @param string $shortDescription
     * @return $this
     */
    public function setShortDescription($shortDescription)
    {
        $this->setData(self::SHORT_DESCRIPTION, (string)$shortDescription);
        return $this;
    }

    /**
     * @return string
     */
    public function getContent()
    {
        return $this->getData(self::SHORT_DESCRIPTION);
    }

    /**
     * @param string $content
     * @return $this
     */
    public function setContent($content)
    {
        $this->setData(self::SHORT_DESCRIPTION, (string)$content);
        return $this;
    }

    /**
     * @return string
     */
    public function getMetaTitle()
    {
        return $this->getData(self::META_TITLE);
    }

    /**
     * @param string $metaTitle
     * @return $this
     */
    public function setMetaTitle($metaTitle)
    {
        $this->setData(self::META_TITLE, (string)$metaTitle);
        return $this;
    }

    /**
     * @return string
     */
    public function getMetaDescription()
    {
        return $this->getData(self::META_DESCRIPTION);
    }

    /**
     * @param string $metaDescription
     * @return $this
     */
    public function setMetaDescription($metaDescription)
    {
        $this->setData(self::META_DESCRIPTION, (string)$metaDescription);
        return $this;
    }

    /**
     * @return string
     */
    public function getMetaKeywords()
    {
        return $this->getData(self::META_KEYWORDS);
    }

    /**
     * @param string $metaKeywords
     * @return $this
     */
    public function setMetaKeywords($metaKeywords)
    {
        $this->setData(self::META_KEYWORDS, (string)$metaKeywords);
        return $this;
    }

    /**
     * @return string
     */
    public function getEnabled()
    {
        return $this->getData(self::ENABLED);
    }

    /**
     * @param string $enabled
     * @return $this
     */
    public function setEnabled($enabled)
    {
        $this->setData(self::ENABLED, (string)$enabled);
        return $this;
    }

    /**
     * @return string
     */
    public function getSortOrder()
    {
        return $this->getData(self::SORT_ORDER);
    }

    /**
     * @param string $sortOrder
     * @return $this
     */
    public function setSortOrder($sortOrder)
    {
        $this->setData(self::SORT_ORDER, (string)$sortOrder);
        return $this;
    }

    /**
     * @return string
     */
    public function getCategory()
    {
        return $this->getData(self::CATEGORY);
    }

    /**
     * @param string $category
     * @return $this
     */
    public function setCategory($category)
    {
        $this->setData(self::CATEGORY, (int)$category);
        return $this;
    }

    /**
     * @return string
     */
    public function getUrlKey()
    {
        return $this->getData(self::URL_KEY);
    }

    /**
     * @param string $urlKey
     * @return $this
     */
    public function setUrlKey($urlKey)
    {
        $this->setData(self::URL_KEY, (string)$urlKey);
        return $this;
    }



    /**
     * @return string
     */
    public function getCreatedAt()
    {
        return $this->getData(self::CREATED_AT);
    }

    /**
     * @param string $createdAt
     * @return $this
     */
    public function setCreatedAt($createdAt)
    {
        $this->setData(self::CREATED_AT, (string)$createdAt);
        return $this;
    }

    /**
     * @return string
     */
    public function getUpdatedAt()
    {
        return $this->getData(self::UPDATED_AT);
    }

    /**
     * @param string $updatedAt
     * @return $this
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->setData(self::UPDATED_AT, (string)$updatedAt);
        return $this;
    }
}
