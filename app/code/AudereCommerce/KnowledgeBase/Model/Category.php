<?php

namespace AudereCommerce\KnowledgeBase\Model;

use \Magento\Catalog\Api\Data\CategorySearchResultsInterface;
use \Magento\Catalog\Api\Data\ProductSearchResultsInterface;
use \Magento\Framework\Model\AbstractModel;
use AudereCommerce\KnowledgeBase\Api\Data\PostSearchResultsInterface;
use AudereCommerce\KnowledgeBase\Api\Data\CategoryInterface;
use AudereCommerce\KnowledgeBase\Api\CategoryManagementInterface;

class Category extends AbstractModel implements CategoryInterface
{
    const ID = 'id';

    const TITLE = 'title';

    const DESCRIPTION = 'description';

    const URL_KEY = 'url_key';

    const SORT_ORDER = 'sort_order';

    const PARENT_ID = 'parent_id';

    /**
     * @var CategoryManagementInterface
     */
    protected $_categoryManagementInterface;

    /**
     * @param CategoryManagementInterface $categoryManagementInterface
     * @param \Magento\Framework\Model\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param \Magento\Framework\Model\ResourceModel\AbstractResource $resource
     * @param \Magento\Framework\Data\Collection\AbstractDb $resourceCollection
     * @param array $data
     */
    public function __construct(CategoryManagementInterface $categoryManagementInterface, \Magento\Framework\Model\Context $context, \Magento\Framework\Registry $registry, \Magento\Framework\Model\ResourceModel\AbstractResource $resource = null, \Magento\Framework\Data\Collection\AbstractDb $resourceCollection = null, array $data = array())
    {
        $this->_categoryManagementInterface = $categoryManagementInterface;
        parent::__construct($context, $registry, $resource, $resourceCollection, $data);
    }

    public function _construct()
    {
        $this->_init('AudereCommerce\KnowledgeBase\Model\ResourceModel\Category');
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
    public function getDescription()
    {
        return $this->getData(self::DESCRIPTION);
    }

    /**
     * @param string $description
     * @return $this
     */
    public function setDescription($description)
    {
        $this->setData(self::DESCRIPTION, (string)$description);
        return $this;
    }

    /**
     * @return string
     */
    public function getIconImage()
    {
        return $this->getData(self::DESCRIPTION);
    }

    /**
     * @param string $iconImage
     * @return $this
     */
    public function setIconImage($iconImage)
    {
        $this->setData(self::DESCRIPTION, (string)$iconImage);
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
     * @return int
     */
    public function getSortOrder()
    {
        return $this->getData(self::SORT_ORDER);
    }

    /**
     * @param int $sortOrder
     * @return $this
     */
    public function setSortOrder($sortOrder)
    {
        $this->setData(self::SORT_ORDER, (int)$sortOrder);
        return $this;
    }

    /**
     * @return int
     */
    public function getParentId()
    {
        return $this->getData(self::PARENT_ID);
    }

    /**
     * @param int $parentId
     * @return $this
     */
    public function setParentId($parentId)
    {
        $this->setData(self::PARENT_ID, (int)$parentId);
        return $this;
    }

    /**
     * @return PostSearchResultsInterface
     */
    public function getKnowledgeBase()
    {
        return $this->_categoryManagementInterface->getKnowledgeBase($this);
    }
}
