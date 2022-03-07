<?php

namespace AudereCommerce\KnowledgeBase\Api;

use \Magento\Framework\Api\SearchCriteriaInterface;
use AudereCommerce\KnowledgeBase\Api\Data\PostInterface;
use AudereCommerce\KnowledgeBase\Api\Data\PostSearchResultsInterface;

interface PostRepositoryInterface
{

    /**
     * @param PostInterface $download
     * @return PostInterface
     */
    public function save(PostInterface $download);

    /**
     * @param int $id
     * @param bool $forceReload
     * @return PostInterface
     */
    public function getById($id, $forceReload = false);

    /**
     * @param SearchCriteriaInterface $searchCriteria
     * @return PostSearchResultsInterface
     */
    public function getList(SearchCriteriaInterface $searchCriteria);

    /**
     * @param PostInterface $download
     * @return bool
     */
    public function delete(PostInterface $download);
}
