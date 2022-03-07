<?php

namespace AudereCommerce\KnowledgeBase\Model\ResourceModel\Category;

use \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use AudereCommerce\KnowledgeBase\Api\Data\CategorySearchResultsInterface;

class Collection extends AbstractCollection implements CategorySearchResultsInterface
{

    public function _construct()
    {
        $this->_init('AudereCommerce\KnowledgeBase\Model\Category', 'AudereCommerce\KnowledgeBase\Model\ResourceModel\Category');
    }
}
