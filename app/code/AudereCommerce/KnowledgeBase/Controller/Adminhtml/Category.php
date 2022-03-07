<?php

namespace AudereCommerce\KnowledgeBase\Controller\Adminhtml;

use AudereCommerce\KnowledgeBase\Api\CategoryRepositoryInterface;
use AudereCommerce\KnowledgeBase\Controller\Adminhtml\Category\PostDataProcessor;
use AudereCommerce\KnowledgeBase\Model\CategoryFactory;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\Registry;
use Magento\Framework\View\Result\PageFactory;

abstract class Category extends Action
{

    const ADMIN_RESOURCE = 'AudereCommerce_KnowledgeBase::category';

    /**
     * @var DataPersistorInterface
     */
    protected $_dataPersistor;

    /**
     * @var CategoryFactory
     */
    protected $_categoryFactory;

    /**
     * @var CategoryRepositoryInterface
     */
    protected $_categoryRepositoryInterface;

    /**
     * @var PostDataProcessor
     */
    protected $_postDataProcessor;

    /**
     * @var Registry
     */
    protected $_registry;

    /**
     * @var PageFactory
     */
    protected $_resultPageFactory;

    /**
     * @param Context $context
     * @param Registry $registry
     * @param PageFactory $resultPageFactory
     * @param DataPersistorInterface $dataPersistor
     * @param CategoryFactory $categoryFactory
     * @param CategoryRepositoryInterface $categoryRepositoryInterface
     * @param PostDataProcessor $postDataProcessor
     */
    public function __construct(Context $context, Registry $registry, PageFactory $resultPageFactory, DataPersistorInterface $dataPersistor, CategoryFactory $categoryFactory, CategoryRepositoryInterface $categoryRepositoryInterface, PostDataProcessor $postDataProcessor)
    {
        parent::__construct($context);
        $this->_registry = $registry;
        $this->_resultPageFactory = $resultPageFactory;
        $this->_dataPersistor = $dataPersistor;
        $this->_categoryFactory = $categoryFactory;
        $this->_categoryRepositoryInterface = $categoryRepositoryInterface;
        $this->_postDataProcessor = $postDataProcessor;
    }

    /**
     * @return bool
     */
    public function _isAllowed()
    {
        return $this->_authorization->isAllowed(self::ADMIN_RESOURCE);
    }
}
