<?php

namespace AudereCommerce\KnowledgeBase\Model\Post\CategoryId;

use AudereCommerce\KnowledgeBase\Model\CategoryRepository;
use Magento\Framework\Api\SearchCriteriaBuilderFactory;
use Magento\Framework\Data\OptionSourceInterface;

class Options implements OptionSourceInterface
{

    /**
     * @var CategoryRepository
     */
    protected $_categoryRepository;

    /**
     * @var array
     */
    protected $_options;

    /**
     * @var SearchCriteriaBuilderFactory
     */
    protected $_searchCriteriaBuilderFactory;

    /**
     * @param SearchCriteriaBuilderFactory $searchCriteriaBuilderFactory
     * @param CategoryRepository $categoryRepository
     */
    public function __construct(SearchCriteriaBuilderFactory $searchCriteriaBuilderFactory, CategoryRepository $categoryRepository)
    {
        $this->_searchCriteriaBuilderFactory = $searchCriteriaBuilderFactory;
        $this->_categoryRepository = $categoryRepository;
    }

    /**
     * @return array
     */
    public function toOptionArray()
    {
        if ($this->_options == null) {
            $searchCriteriaBuilder = $this->_searchCriteriaBuilderFactory->create();
            $searchResults = $this->_categoryRepository->getList($searchCriteriaBuilder->create());

            $options = array();

            foreach ($searchResults->getItems() as $category) {
                $options[] = array(
                    'value' => $category->getId(),
                    'label' => $category->getTitle()
                );
            }

            $this->_options = $options;
        }

        return $this->_options;
    }
}
