<?php

namespace AudereCommerce\KnowledgeBase\Controller\Adminhtml;

use AudereCommerce\KnowledgeBase\Api\PostRepositoryInterface;
use AudereCommerce\KnowledgeBase\Controller\Adminhtml\Post\PostDataProcessor;
use AudereCommerce\KnowledgeBase\Model\PostFactory;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\Registry;
use Magento\Framework\View\Result\PageFactory;

abstract class Post extends Action
{

    const ADMIN_RESOURCE = 'AudereCommerce_KnowledgeBase::post';

    /**
     * @var DataPersistorInterface
     */
    protected $_dataPersistor;

    /**
     * @var PostFactory
     */
    protected $_postFactory;

    /**
     * @var PostRepositoryInterface
     */
    protected $_postRepositoryInterface;

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
     * @param PostFactory $postFactory
     * @param PostRepositoryInterface $postRepositoryInterface
     * @param PostDataProcessor $postDataProcessor
     */
    public function __construct(Context $context, Registry $registry, PageFactory $resultPageFactory, DataPersistorInterface $dataPersistor, PostFactory $postFactory, PostRepositoryInterface $postRepositoryInterface, PostDataProcessor $postDataProcessor)
    {
        parent::__construct($context);
        $this->_registry = $registry;
        $this->_resultPageFactory = $resultPageFactory;
        $this->_dataPersistor = $dataPersistor;
        $this->_postFactory = $postFactory;
        $this->_postRepositoryInterface = $postRepositoryInterface;
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
