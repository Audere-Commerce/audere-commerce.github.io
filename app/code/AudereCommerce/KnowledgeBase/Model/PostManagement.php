<?php

namespace AudereCommerce\KnowledgeBase\Model;

use \AudereCommerce\KnowledgeBase\Api\Data\CategoryInterface;
use \AudereCommerce\KnowledgeBase\Model\CategoryRepository;
use AudereCommerce\KnowledgeBase\Api\PostManagementInterface;
use AudereCommerce\KnowledgeBase\Model\Post;

class PostManagement implements PostManagementInterface
{

    /**
     * @var CategoryRepository
     */
    protected $_categoryRepository;

    /**
     * @param TypeRepository $typeRepository
     * @param CategoryRepository $categoryRepository
     */
    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->_categoryRepository = $categoryRepository;
    }

    /**
     * @param Post $model
     * @return CategoryInterface
     */
    public function getCategory(Post $model)
    {
        return $this->_categoryRepository->getById($model->getData('category_id'));
    }
}
