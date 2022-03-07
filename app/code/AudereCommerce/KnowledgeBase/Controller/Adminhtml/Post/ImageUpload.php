<?php

namespace AudereCommerce\KnowledgeBase\Controller\Adminhtml\Post;

use AudereCommerce\KnowledgeBase\Api\PostRepositoryInterface;
use AudereCommerce\KnowledgeBase\Controller\Adminhtml\Post;
use AudereCommerce\KnowledgeBase\Model\PostFactory;
use Magento\Backend\App\Action\Context;
use Magento\Catalog\Model\ImageUploader;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Registry;
use Magento\Framework\View\Result\PageFactory;

class ImageUpload extends Post
{

    /**
     * @var ImageUploader
     */
    protected $_imageUploader;

    /**
     * @param Context $context
     * @param Registry $registry
     * @param PageFactory $resultPageFactory
     * @param DataPersistorInterface $dataPersistor
     * @param PostFactory $postFactory
     * @param PostRepositoryInterface $postRepositoryInterface
     * @param PostDataProcessor $dataProcessor
     * @param ImageUploader $imageUploader
     */
    public function __construct(Context $context, Registry $registry, PageFactory $resultPageFactory, DataPersistorInterface $dataPersistor, PostFactory $postFactory, PostRepositoryInterface $postRepositoryInterface, PostDataProcessor $dataProcessor, ImageUploader $imageUploader)
    {
        $this->_imageUploader = $imageUploader;
        parent::__construct(
            $context,
            $registry,
            $resultPageFactory,
            $dataPersistor,
            $postFactory,
            $postRepositoryInterface,
            $dataProcessor
        );
    }

    /**
     * @return ResultInterface
     */
    public function execute()
    {
        $imageId = $this->_request->getParam('param_name', 'post[thumbnail_image]');

        try {
            $result = $this->_imageUploader->saveFileToTmpDir($imageId);

            $result['cookie'] = array(
                'name' => $this->_getSession()->getName(),
                'value' => $this->_getSession()->getSessionId(),
                'lifetime' => $this->_getSession()->getCookieLifetime(),
                'path' => $this->_getSession()->getCookiePath(),
                'domain' => $this->_getSession()->getCookieDomain()
            );
        } catch (\Exception $e) {
            $result = array('error' => $e->getMessage(), 'errorcode' => $e->getCode());
        }

        return $this->resultFactory->create(ResultFactory::TYPE_JSON)->setData($result);
    }
}
