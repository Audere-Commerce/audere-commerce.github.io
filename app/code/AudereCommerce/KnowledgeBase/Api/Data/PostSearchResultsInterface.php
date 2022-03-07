<?php

namespace AudereCommerce\KnowledgeBase\Api\Data;

use AudereCommerce\KnowledgeBase\Api\Data\PostInterface;

interface PostSearchResultsInterface
{

    /**
     * @return PostInterface[]
     */
    public function getItems();
}
