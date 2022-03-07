<?php

namespace AudereCommerce\KnowledgeBase\Helper;

use AudereCommerce\KnowledgeBase\Api\Data\PostInterface;
use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Helper\Context;
use AudereCommerce\KnowledgeBase\Model\ResourceModel\Post\CollectionFactory as PostCollectionFactory;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Widget\Model\Template\Filter;
use Magento\Framework\App\ResourceConnection;
use Magento\Catalog\Model\ResourceModel\Product\CollectionFactory as ProductCollectionFactory;
use AudereCommerce\KnowledgeBase\Model\ResourceModel\Category\CollectionFactory as CategoryCollectionFactory;
use Magento\Framework\View\Element\Template;

class KnowledgeBase extends AbstractHelper
{
    /**
     * @var PostCollectionFactory
     */
    protected $postCollectionFactory;

    /**
     * @var StoreManagerInterface
     */
    protected $storeManager;

    /**
     * @var Filter
     */
    protected $filter;

    /**
     * @var ResourceConnection
     */
    protected $resourceConnection;

    /**
     * @var ProductCollectionFactory
     */
    protected $productCollectionFactory;

    /**
     * @var CategoryCollectionFactory
     */
    protected $categoryCollectionFactory;

    /**
     * @var Template
     */
    protected $template;

    public function __construct(
        Context $context,
        PostCollectionFactory $postCollectionFactory,
        StoreManagerInterface $storeManager,
        Filter $filter,
        ResourceConnection $resourceConnection,
        ProductCollectionFactory $productCollectionFactory,
        CategoryCollectionFactory $categoryCollectionFactory,
        Template $template
    )
    {
        parent::__construct($context);
        $this->postCollectionFactory = $postCollectionFactory;
        $this->storeManager = $storeManager;
        $this->filter = $filter;
        $this->resourceConnection = $resourceConnection;
        $this->productCollectionFactory = $productCollectionFactory;
        $this->categoryCollectionFactory = $categoryCollectionFactory;
        $this->template = $template;
    }

    public function getPostImage($image, PostInterface $post)
    {
        $mediaUrl = $this->storeManager->getStore()->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA);
        $imageKey = $post->getData($image);

        if ($imageKey) {
            return $mediaUrl . 'knowledgebase/post/' . $imageKey;
        }

        return false;
    }

    public function outputHtml($content)
    {
        return $this->filter->filter($content);
    }

    public function getPostProducts(PostInterface $post)
    {
        $postId = $post->getId();

        $connection = $this->resourceConnection->getConnection();

        $select = $connection->select()
            ->from(array('appp' => $connection->getTableName('auderecommerce_knowledgebase_post_product')))
            ->where('appp.post_id = ?', $postId)
            ->columns(array('product_id'));

        $productIds = array();

        foreach ($connection->fetchAll($select) as $item) {
            $productIds[] = $item['product_id'];
        }

        $productCollection = $this->productCollectionFactory->create()
            ->addFieldToFilter('entity_id', array('in', $productIds))
            ->addAttributeToSelect('*');

        return $productCollection->getItems();
    }

    public function getPostCategories()
    {
        return $this->categoryCollectionFactory->create()
            ->addFieldToSelect('*')
            ->getItems();
    }

    public function createCategoryUrl($categoryId)
    {
        $queryParams = array(
            'category' => $categoryId
        );

        $categoryUrl = $this->template->getUrl('knowledgebase', ['_use_rewrite' => true, '_query' => $queryParams]);

        return $categoryUrl;
    }

    public function isCategoryActive($categoryId)
    {
        if (isset($_GET['category'])) {
            if ($_GET['category'] == $categoryId) {
                return true;
            }
        }

        return false;
    }

    public function showKnowledgeBaseLink()
    {
        $connection = $this->resourceConnection->getConnection();

        $select = $connection->select()
            ->from(array('app' => $connection->getTableName('auderecommerce_knowledgebase_post')))
            ->where('app.enabled = ?', 1);

        if (count($connection->fetchAll($select))) {
            return true;
        }

        return false;
    }
}
