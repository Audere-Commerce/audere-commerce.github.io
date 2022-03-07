<?php

namespace AudereCommerce\KnowledgeBase\Api\Data;

use \Magento\Catalog\Api\Data\CategorySearchResultsInterface;
use \Magento\Catalog\Api\Data\ProductSearchResultsInterface;
use AudereCommerce\KnowledgeBase\Api\Data\PostSearchResultsInterface;
use AudereCommerce\KnowledgeBase\Model\ResourceModel\Category;

interface CategoryInterface
{

    const ENTITY_TYPE = 'category';

    /**
     * @return Category
     */
    public function getResource();

    /**
     * @return int
     */
    public function getId();

    /**
     * @param int $id
     * @return $this
     */
    public function setId($id);

    /**
     * @return string
     */
    public function getTitle();

    /**
     * @param string $title
     * @return $this
     */
    public function setTitle($title);

    /**
     * @return string
     */
    public function getDescription();

    /**
     * @param string $description
     * @return $this
     */
    public function setDescription($description);

    /**
     * @return string
     */
    public function getIconImage();

    /**
     * @param string $iconImage
     * @return $this
     */
    public function setIconImage($iconImage);

    /**
     * @return int
     */
    public function getParentId();

    /**
     * @param int $parentId
     * @return $this
     */
    public function setParentId($parentId);

    /**
     * @return int
     */
    public function getSortOrder();

    /**
     * @param int $sortOrder
     * @return $this
     */
    public function setSortOrder($sortOrder);

    /**
     * @return string
     */
    public function getUrlKey();

    /**
     * @param string $urlKey
     * @return $this
     */
    public function setUrlKey($urlKey);

    /**
     * @return PostSearchResultsInterface
     */
    public function getKnowledgeBase();
}
