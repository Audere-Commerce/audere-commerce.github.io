<?php

namespace AudereCommerce\KnowledgeBase\Model;

use \Magento\Framework\Api\Filter;
use \Magento\Framework\Api\Search\FilterGroup;
use \Magento\Framework\Api\SearchCriteriaInterface;
use \Magento\Framework\Exception\NoSuchEntityException;
use AudereCommerce\KnowledgeBase\Api\Data\PostInterface;
use AudereCommerce\KnowledgeBase\Api\Data\PostSearchResultsInterface;
use AudereCommerce\KnowledgeBase\Api\PostRepositoryInterface;
use AudereCommerce\KnowledgeBase\Model\PostFactory;
use AudereCommerce\KnowledgeBase\Model\ResourceModel\Post\CollectionFactory;

class PostRepository implements PostRepositoryInterface
{

    /**
     * @var CollectionFactory
     */
    protected $_postCollectionFactory;

    /**
     * @var PostFactory
     */
    protected $_postFactory;

    /**
     * @var PostInterface[]
     */
    protected $_instancesById = array();

    /**
     * @param CollectionFactory $postCollectionFactory
     * @param PostFactory $postFactory
     */
    public function __construct(CollectionFactory $postCollectionFactory, PostFactory $postFactory)
    {
        $this->_postCollectionFactory = $postCollectionFactory;
        $this->_postFactory = $postFactory;
    }

    /**
     * @param PostInterface $post
     * @return PostInterface
     */
    public function save(PostInterface $post)
    {
        return $post->getResource()->save($post);
    }

    /**
     * @param int $id
     * @param bool $forceReload
     * @return PostInterface
     */
    public function getById($id, $forceReload = false)
    {
        if (!isset($this->_instancesById[$id]) || $forceReload) {
            $model = $this->_postFactory->create();
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
     * @return PostSearchResultsInterface
     */
    public function getList(SearchCriteriaInterface $searchCriteria)
    {
        $postCollection = $this->_postCollectionFactory->create();
        $filterGroups = $searchCriteria->getFilterGroups();

        foreach ($filterGroups as $filterGroup) {
            foreach ($filterGroup->getFilters() as $filter) {
                $condition = $filter->getConditionType() ? $filter->getConditionType() : 'eq';
                $postCollection->addFieldToFilter($filter->getField(), array($condition => $filter->getValue()));
            }
        }

        return $postCollection;
    }

    /**
     * @param PostInterface $post
     * @return bool
     */
    public function delete(PostInterface $post)
    {
        $id = $post->getId();

        try {
            unset($this->_instancesById[$id]);
            $post->getResource()->delete($post);
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
