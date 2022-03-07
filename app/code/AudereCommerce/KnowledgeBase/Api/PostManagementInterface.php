<?php

namespace AudereCommerce\KnowledgeBase\Api;

use AudereCommerce\KnowledgeBase\Api\Data\CategoryInterface;
use AudereCommerce\KnowledgeBase\Model\Post;

interface PostManagementInterface
{
    /**
     * @param Post $model
     * @return CategoryInterface
     */
    public function getCategory(Post $model);
}
