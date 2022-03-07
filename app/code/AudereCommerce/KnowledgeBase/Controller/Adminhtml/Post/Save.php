<?php

namespace AudereCommerce\KnowledgeBase\Controller\Adminhtml\Post;

use AudereCommerce\KnowledgeBase\Api\PostRepositoryInterface;
use AudereCommerce\KnowledgeBase\Controller\Adminhtml\Post;
use AudereCommerce\KnowledgeBase\Model\PostFactory;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\App\ResourceConnection;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Registry;
use Magento\Framework\View\Result\PageFactory;

class Save extends Post
{

    const ADMIN_RESOURCE = 'AudereCommerce_KnowledgeBase::post_save';

    /**
     * @var ResourceConnection
     */
    protected $_resource;

    /**
     * @param Context $context
     * @param Registry $registry
     * @param PageFactory $resultPageFactory
     * @param DataPersistorInterface $dataPersistor
     * @param PostFactory $postFactory
     * @param PostRepositoryInterface $postRepositoryInterface
     * @param PostDataProcessor $dataProcessor
     * @param ResourceConnection $resourceConnection
     */
    public function __construct(Context $context, Registry $registry, PageFactory $resultPageFactory, DataPersistorInterface $dataPersistor, PostFactory $postFactory, PostRepositoryInterface $postRepositoryInterface, PostDataProcessor $dataProcessor, ResourceConnection $resourceConnection)
    {
        $this->_resource = $resourceConnection;
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

    public function execute()
    {
        $resultRedirect = $this->resultRedirectFactory->create();
        $data = $this->getRequest()->getPostValue();

        if ($data) {
            $postData = $data['post'];
            $postData = $this->imagePreprocessing($postData);

            if ($postData['id'] == '') {
                $postData['id'] = null;
            }

            $id = $postData['id'];
            $model = $id ? $this->_postRepositoryInterface->getById($id) : $this->_postFactory->create();

            try {
                if ($urlKey = $this->setUrlKey($postData)) {
                    $postData['url_key'] = $urlKey;
                } else {
                    $this->messageManager->addErrorMessage(__('The URL Key you entered is not unique.'));
                    return $resultRedirect->setPath($this->_redirect->getRefererUrl());
                }

                $model->setData($postData);

                $this->_postRepositoryInterface->save($model);

                $this->_saveRelations($model, $data);

                $this->messageManager->addSuccessMessage(__('You saved the Post'));
                $this->_dataPersistor->clear('post');

                if ($this->getRequest()->getParam('back')) {
                    return $resultRedirect->setPath('*/*/', array('id' => $model->getId(), '_current' => true));
                }

                return $resultRedirect->setPath('*/*/');

            } catch (LocalizedException $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
            } catch (\Exception $e) {
                $this->messageManager->addExceptionMessage($e, __('Something went wrong while saving the Post.'));
            }

            $this->_dataPersistor->set('post', $data);
            return $resultRedirect->setPath('*/*/edit', array('id' => $id));
        }

        return $resultRedirect->setPath('*/*/');
    }

    public function setUrlKey($data)
    {
        $urlKey = strToLower(preg_replace('%[^a-z0-9_-]%six','-', $data['url_key']));

        $connection = $this->_resource->getConnection();

        $select = $connection
            ->select()
            ->from($this->_resource->getTableName('auderecommerce_knowledgebase_post'), '')
            ->where('url_key = ?', $urlKey)
            ->columns(array('id', 'url_key'));

        $matchingPostByUrlKey = $connection->fetchRow($select);

        if ($matchingPostByUrlKey && $matchingPostByUrlKey['id'] != $data['id']) {
            return false;
        }

        return $urlKey;
    }

    /**
     * @param array $data
     * @return array
     */
    public function imagePreprocessing(array $data)
    {
        $images = array(
            'main_image',
            'listing_image',
            'post_consultant_image',
            'layout_one_mosaic_image_one',
            'layout_one_mosaic_image_two',
            'layout_one_mosaic_image_three',
            'layout_one_mosaic_image_four',
            'layout_one_fullwidth_image',
            'layout_two_mosaic_image_one',
            'layout_two_mosaic_image_two',
        );

        foreach ($images as $image) {
            if (!isset($data[$image])) {
                $data[$image] = false;
            } elseif (isset($data[$image][0]['file'])) {
                $data[$image] = $data[$image][0]['file'];
            } elseif (isset($data[$image][0]['name'])) {
                $data[$image] = $data[$image][0]['name'];
            }
        }

        return $data;
    }

    /**
     * @param $post
     * @param array $data
     */
    protected function _saveRelations($post, array $data)
    {
        $connection = $this->_resource->getConnection();

        $table = $connection->getTableName('auderecommerce_knowledgebase_post_product');

        $select = $connection->select()
            ->from($table)
            ->where('post_id = ?', $post->getId());

        $connection->query($connection->deleteFromSelect($select, $table));

        if (isset($data['links'])) {
            $links = $data['links'];

            if (isset($links['product']) && is_array($links['product'])) {
                foreach ($links['product'] as $product) {
                    $connection->insert($table, array(
                        'post_id' => $post->getId(),
                        'product_id' => $product['id']
                    ));
                }
            }
        }
    }
}
