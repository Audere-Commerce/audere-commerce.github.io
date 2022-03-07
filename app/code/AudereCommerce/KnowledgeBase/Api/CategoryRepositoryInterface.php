<?php

namespace AudereCommerce\KnowledgeBase\Api;

use \Magento\Framework\Api\SearchCriteriaInterface;
use AudereCommerce\KnowledgeBase\Api\Data\CategoryInterface;
use AudereCommerce\KnowledgeBase\Api\Data\CategorySearchResultsInterface;

interface CategoryRepositoryInterface
{

    /**
     * @param CategoryInterface $group
     * @return CategoryInterface
     */
    public function save(CategoryInterface $group);

    /**
     * @param int $id
     * @param bool $forceReload
     * @return CategoryInterface
     */
    public function getById($id, $forceReload = false);

    /**
     * @param SearchCriteriaInterface $searchCriteria
     * @return CategorySearchResultsInterface
     */
    public function getList(SearchCriteriaInterface $searchCriteria);

    /**
     * @param CategoryInterface $group
     * @return bool
     */
    public function delete(CategoryInterface $group);
}
