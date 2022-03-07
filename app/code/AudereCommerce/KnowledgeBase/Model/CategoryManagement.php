<?php

namespace AudereCommerce\KnowledgeBase\Model;

use Magento\Catalog\Api\Data\CategorySearchResultsInterface;
use Magento\Catalog\Api\Data\ProductSearchResultsInterface;
use Magento\Catalog\Model\CategoryRepository;
use Magento\Catalog\Model\ProductRepository;
use Magento\Catalog\Model\ResourceModel\Category\CollectionFactory as CategoryCollectionFactory;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\App\ResourceConnection;
use AudereCommerce\KnowledgeBase\Api\Data\PostSearchResultsInterface;
use AudereCommerce\KnowledgeBase\Api\CategoryManagementInterface;
use AudereCommerce\KnowledgeBase\Model\PostRepository;
use AudereCommerce\KnowledgeBase\Model\Category;

class CategoryManagement implements CategoryManagementInterface
{

    /**
     * @var CategoryRepository
     */
    protected $_categoryRepository;

    /**
     * @var PostRepository
     */
    protected $_postRepository;

    /**
     * @var ProductRepository
     */
    protected $_productRepository;

    /**
     * @var ResourceConnection
     */
    protected $_resource;

    /**
     * @var SearchCriteriaBuilder
     */
    protected $_searchCriteriaBuilder;

    /**
     * @var CategoryCollectionFactory
     */
    protected $_categoryCollectionFactory;

    public function __construct(ResourceConnection $resource, SearchCriteriaBuilder $searchCriteriaBuilder, CategoryRepository $categoryRepository, ProductRepository $productRepository, PostRepository $postRepository, CategoryCollectionFactory $categoryCollectionFactory)
    {
        $this->_resource = $resource;
        $this->_searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->_categoryRepository = $categoryRepository;
        $this->_productRepository = $productRepository;
        $this->_postRepository = $postRepository;
        $this->_categoryCollectionFactory = $categoryCollectionFactory;
    }

    /**
     * @param Category $model
     * @return CategorySearchResultsInterface|\Magento\Framework\DataObject[]
     */
    public function getCategories(Category $model)
    {
        $connection = $this->_resource->getConnection();

        $select = $connection->select()
            ->from($this->_resource->getTableName('auderecommerce_knowledgebase_post_category'))
            ->where('category_id = ?', $model->getId());

        $categoryIds = array();

        foreach ($connection->fetchAll($select) as $row) {
            $categoryIds[] = $row['catalog_category_entity_id'];
        }

        $collection = $this->_categoryCollectionFactory
            ->create()
            ->addFieldToFilter('entity_id', array('in' => $categoryIds));

        return $collection->getItems();
    }

    /**
     * @param Category $model
     * @return ProductSearchResultsInterface
     */
    public function getProducts(Category $model)
    {
        $connection = $this->_resource->getConnection();

        $select = $connection->select()
            ->from($this->_resource->getTableName('auderecommerce_knowledgebase_post_product'))
            ->where('category_id = ?', $model->getId());

        $productIds = array();

        foreach ($connection->fetchAll($select) as $row) {
            $productIds[] = $row['catalog_product_entity_id'];
        }

        $searchCriteria = $this->_searchCriteriaBuilder
            ->addFilter('entity_id', $productIds, 'in')
            ->create();

        return $this->_productRepository->getList($searchCriteria);
    }

    /**
     * @param Category $model
     * @return PostSearchResultsInterface
     */
    public function getKnowledgeBase(Category $model)
    {
        $searchCriteria = $this->_searchCriteriaBuilder
            ->addFilter('category_id', $model->getData('id'), 'in')
            ->create();

        return $this->_postRepository->getList($searchCriteria);
    }
}
