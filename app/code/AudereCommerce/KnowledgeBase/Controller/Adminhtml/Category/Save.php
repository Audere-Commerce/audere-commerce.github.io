<?php

namespace AudereCommerce\KnowledgeBase\Controller\Adminhtml\Category;

use AudereCommerce\KnowledgeBase\Api\CategoryRepositoryInterface;
use AudereCommerce\KnowledgeBase\Controller\Adminhtml\Category;
use AudereCommerce\KnowledgeBase\Model\CategoryFactory;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\App\ResourceConnection;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Registry;
use Magento\Framework\View\Result\PageFactory;

class Save extends Category
{

    const ADMIN_RESOURCE = 'AudereCommerce_KnowledgeBase::category_save';

    /**
     * @var ResourceConnection
     */
    protected $_resource;

    /**
     * @param Context $context
     * @param Registry $registry
     * @param PageFactory $resultPageFactory
     * @param DataPersistorInterface $dataPersistor
     * @param CategoryFactory $categoryFactory
     * @param CategoryRepositoryInterface $categoryRepositoryInterface
     * @param PostDataProcessor $dataProcessor
     * @param ResourceConnection $resourceConnection
     */
    public function __construct(Context $context, Registry $registry, PageFactory $resultPageFactory, DataPersistorInterface $dataPersistor, CategoryFactory $categoryFactory, CategoryRepositoryInterface $categoryRepositoryInterface, PostDataProcessor $dataProcessor, ResourceConnection $resourceConnection)
    {
        $this->_resource = $resourceConnection;
        parent::__construct(
            $context,
            $registry,
            $resultPageFactory,
            $dataPersistor,
            $categoryFactory,
            $categoryRepositoryInterface,
            $dataProcessor
        );
    }

    public function execute()
    {
        $resultRedirect = $this->resultRedirectFactory->create();
        $data = $this->getRequest()->getPostValue();

        if ($data) {
            $categoryData = $data['category'];

            if ($categoryData['id'] == '') {
                $categoryData['id'] = null;
            }

            $id = $categoryData['id'];
            $model = $id ? $this->_categoryRepositoryInterface->getById($id) : $this->_categoryFactory->create();

            try {
                $model->setData($categoryData);
                $this->_categoryRepositoryInterface->save($model);

                $this->messageManager->addSuccessMessage(__('You saved the Category'));
                $this->_dataPersistor->clear('category');

                if ($this->getRequest()->getParam('back')) {
                    return $resultRedirect->setPath('*/*/', array('id' => $model->getId(), '_current' => true));
                }

                return $resultRedirect->setPath('*/*/');

            } catch (LocalizedException $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
            } catch (\Exception $e) {
                $this->messageManager->addExceptionMessage($e, __('Something went wrong while saving the Category.'));
            }

            $this->_dataPersistor->set('category', $data);
            return $resultRedirect->setPath('*/*/edit', array('id' => $id));
        }

        return $resultRedirect->setPath('*/*/');
    }
}
