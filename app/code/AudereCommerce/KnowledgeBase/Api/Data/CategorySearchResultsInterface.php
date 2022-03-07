<?php

namespace AudereCommerce\KnowledgeBase\Api\Data;

use AudereCommerce\KnowledgeBase\Api\Data\CategoryInterface;

interface CategorySearchResultsInterface
{

    /**
     * @return CategoryInterface[]
     */
    public function getItems();
}
