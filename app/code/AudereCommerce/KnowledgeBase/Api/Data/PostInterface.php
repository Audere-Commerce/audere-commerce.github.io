<?php

namespace AudereCommerce\KnowledgeBase\Api\Data;

use AudereCommerce\KnowledgeBase\Api\Data\CategoryInterface;
use AudereCommerce\KnowledgeBase\Model\ResourceModel\Post;

interface PostInterface
{

    const ENTITY_TYPE = 'post';

    /**
     * @return Post
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
    public function getListingImage();

    /**
     * @param string $listingImage
     * @return $this
     */
    public function setListingImage($listingImage);

    /**
     * @return string
     */
    public function getMainImage();

    /**
     * @param string $mainImage
     * @return $this
     */
    public function setMainImage($mainImage);

    /**
     * @return string
     */
    public function getShortDescription();

    /**
     * @param string $shortDescription
     * @return $this
     */
    public function setShortDescription($shortDescription);

    /**
     * @return string
     */
    public function getContent();

    /**
     * @param string $content
     * @return $this
     */
    public function setContent($content);

    /**
     * @return string
     */
    public function getMetaTitle();

    /**
     * @param string $metaTitle
     * @return $this
     */
    public function setMetaTitle($metaTitle);

    /**
     * @return string
     */
    public function getMetaDescription();

    /**
     * @param string $metaDescription
     * @return $this
     */
    public function setMetaDescription($metaDescription);

    /**
     * @return string
     */
    public function getMetaKeywords();

    /**
     * @param string $metaKeywords
     * @return $this
     */
    public function setMetaKeywords($metaKeywords);

    /**
     * @return int
     */
    public function getEnabled();

    /**
     * @param int $enabled
     * @return $this
     */
    public function setEnabled($enabled);

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
    public function getCreatedAt();

    /**
     * @param string $createdAt
     * @return $this
     */
    public function setCreatedAt($createdAt);

    /**
     * @return string
     */
    public function getUpdatedAt();

    /**
     * @param string $updatedAt
     * @return $this
     */
    public function setUpdatedAt($updatedAt);

    /**
     * @return int
     */
    public function getCategory();

    /**
     * @param string $category
     * @return $this
     */
    public function setCategory($category);

    /**
     * @return string
     */
    public function getUrlKey();

    /**
     * @param string $urlKey
     * @return $this
     */
    public function setUrlKey($urlKey);
}
