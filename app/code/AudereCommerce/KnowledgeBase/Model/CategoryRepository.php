<?php

namespace AudereCommerce\KnowledgeBase\Model;

use \Magento\Framework\Api\Filter;
use \Magento\Framework\Api\Search\FilterGroup;
use \Magento\Framework\Api\SearchCriteriaInterface;
use \Magento\Framework\Exception\NoSuchEntityException;
use AudereCommerce\KnowledgeBase\Api\Data\CategoryInterface;
use AudereCommerce\KnowledgeBase\Api\Data\CategorySearchResultsInterface;
use AudereCommerce\KnowledgeBase\Api\CategoryRepositoryInterface;
use AudereCommerce\KnowledgeBase\Model\CategoryFactory;
use AudereCommerce\KnowledgeBase\Model\ResourceModel\Category\CollectionFactory;

class CategoryRepository implements CategoryRepositoryInterface
{

    /**
     * @var CollectionFactory
     */
    protected $_categoryCollectionFactory;

    /**
     * @var CategoryFactory
     */
    protected $_categoryFactory;

    /**
     * @var CategoryInterface[]
     */
    protected $_instancesById = array();

    /**
     * @param CollectionFactory $categoryCollectionFactory
     * @param CategoryFactory $categoryFactory
     */
    public function __construct(CollectionFactory $categoryCollectionFactory, CategoryFactory $categoryFactory)
    {
        $this->_categoryCollectionFactory = $categoryCollectionFactory;
        $this->_categoryFactory = $categoryFactory;
    }

    /**
     * @param CategoryInterface $category
     * @return CategoryInterface
     */
    public function save(CategoryInterface $category)
    {
        return $category->getResource()->save($category);
    }

    /**
     * @param int $id
     * @param bool $forceReload
     * @return CategoryInterface
     */
    public function getById($id, $forceReload = false)
    {
        if (!isset($this->_instancesById[$id]) || $forceReload) {
            $model = $this->_categoryFactory->create();
            $model->load($id);

            if (!$model->getId()) {
                throw NoSuchEntityException::singleField('id', $id);
            }

            $this->_instancesById[$id] = $model;
        }

        return $this->_instancesById[$id];
    }

    /**
     * @param SearchCriteriaInterface $searchCriteria
     * @return CategorySearchResultsInterface
     */
    public function getList(SearchCriteriaInterface $searchCriteria)
    {
        $categoryCollection = $this->_categoryCollectionFactory->create();
        $filterGroups = $searchCriteria->getFilterGroups();

        foreach ($filterGroups as $filterGroup) {
            foreach ($filterGroup->getFilters() as $filter) {
                $condition = $filter->getConditionType() ? $filter->getConditionType() : 'eq';
                $categoryCollection->addFieldToFilter($filter->getField(), array($condition => $filter->getValue()));
            }
        }

        return $categoryCollection;
    }

    /**
     * @param CategoryInterface $category
     * @return bool
     */
    public function delete(CategoryInterface $category)
    {
        $id = $category->getId();

        try {
            unset($this->_instancesById[$id]);
            $category->getResource()->delete($category);
        } catch (\Exception $e) {
            throw new \Magento\Framework\Exception\StateException(__('Unable to remove %1', $id));
        }

        return true;
    }

    /**
     * @param int $id
     * @return bool
     */
    public function deleteById($id)
    {
        $model = $this->getById($id);
        return $this->delete($model);
    }
}
