<?php

namespace AudereCommerce\KnowledgeBase\Ui\DataProvider\Post\Form\Related;

use Magento\Catalog\Model\ResourceModel\Product\CollectionFactory;
use Magento\Catalog\Model\ResourceModel\Product\Collection;
use Magento\Ui\DataProvider\AbstractDataProvider;

class ProductDataProvider extends AbstractDataProvider
{

    /**
     * @param string $name
     * @param string $primaryFieldName
     * @param string $requestFieldName
     * @param CollectionFactory $collectionFactory
     * @param array $meta
     * @param array $data
     */
    public function __construct($name, $primaryFieldName, $requestFieldName, CollectionFactory $collectionFactory, array $meta = array(), array $data = array())
    {
        parent::__construct(
            $name,
            $primaryFieldName,
            $requestFieldName,
            $meta,
            $data
        );

        $this->collection = $collectionFactory->create();
    }

    /**
     * @return collection
     */
    public function getCollection()
    {
        $collection = parent::getCollection();
        $collection->addFieldToSelect('*');
        $collection->setVisibility([\Magento\Catalog\Model\Product\Visibility::VISIBILITY_IN_CATALOG, \Magento\Catalog\Model\Product\Visibility::VISIBILITY_BOTH]);

        return $collection;
    }

    /**
     * @return array
     */
    public function getData()
    {
        if (!$this->getCollection()->isLoaded()) {
            $this->getCollection()->load();
        }

        $items = $this->getCollection()->toArray();

        return array(
            'totalRecords' => $this->getCollection()->getSize(),
            'items' => array_values($items)
        );
    }
}
