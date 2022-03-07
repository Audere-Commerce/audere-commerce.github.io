<?php

namespace AudereCommerce\KnowledgeBase\Model\ResourceModel\Post;

use \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use AudereCommerce\KnowledgeBase\Api\Data\PostSearchResultsInterface;

class Collection extends AbstractCollection implements PostSearchResultsInterface
{

    public function _construct()
    {
        $this->_init('AudereCommerce\KnowledgeBase\Model\Post', 'AudereCommerce\KnowledgeBase\Model\ResourceModel\Post');
    }
}
