<?php

namespace AudereCommerce\KnowledgeBase\Api;

use AudereCommerce\KnowledgeBase\Model\Category;
use AudereCommerce\KnowledgeBase\Api\Data\DownloadInterface;
use AudereCommerce\KnowledgeBase\Api\Data\DownloadSearchResultsInterface;
use AudereCommerce\KnowledgeBase\Model\Group;

interface CategoryManagementInterface
{
    /**
     * @param Category $model
     * @return \AudereCommerce\KnowledgeBase\Api\Data\PostSearchResultsInterface
     */
    public function getKnowledgeBase(Category $model);
}
