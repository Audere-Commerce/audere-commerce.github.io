<?php

namespace AudereCommerce\AudereCommerce\Helper;

use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Helper\Context;
use Magento\Framework\App\ResourceConnection;
use Magefan\Blog\Api\CategoryRepositoryInterface;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\Filesystem;
use Magento\Framework\Image\AdapterFactory;
use Magento\Framework\View\Element\Template;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Framework\Registry;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Api\SearchCriteriaBuilderFactory;
use Magento\Framework\App\RequestInterface;

class Blog extends AbstractHelper
{
    /**
     * Custom directory relative to the "media" folder
     */
    const DIRECTORY = '';

    /**
     * @var ResourceConnection
     */
    protected $resourceConnection;

    /**
     * @var CategoryRepositoryInterface
     */
    protected $categoryRepository;

    /**
     * @var ScopeConfigInterface
     */
    protected $scopeConfig;

    /**
     * @var Template
     */
    protected $template;

    /**
     * @var StoreManagerInterface
     */
    protected $storeManager;

    /**
     * @var Registry
     */
    protected $registry;

    /**
     * @var Filesystem
     */
    protected $fileSystem;

    /**
     * @var Filesystem\Directory\WriteInterface
     */
    protected $mediaDirectory;

    /**
     * @var AdapterFactory
     */
    protected $imageFactory;

    /**
     * @var SearchCriteriaInterface
     */
    protected $searchCriteria;

    /**
     * @var RequestInterface
     */
    protected $request;

    public function __construct(
        Context $context,
        ResourceConnection $resourceConnection,
        CategoryRepositoryInterface $categoryRepository,
        ScopeConfigInterface $scopeConfig,
        Template $template,
        StoreManagerInterface $storeManager,
        Registry $registry,
        Filesystem $fileSystem,
        AdapterFactory $imageFactory,
        SearchCriteriaInterface $searchCriteria,
        RequestInterface $request
    )
    {
        parent::__construct($context);
        $this->mediaDirectory = $fileSystem->getDirectoryWrite(DirectoryList::MEDIA);
        $this->resourceConnection = $resourceConnection;
        $this->categoryRepository = $categoryRepository;
        $this->scopeConfig = $scopeConfig;
        $this->template = $template;
        $this->storeManager = $storeManager;
        $this->registry = $registry;
        $this->fileSystem = $fileSystem;
        $this->imageFactory = $imageFactory;
        $this->searchCriteria = $searchCriteria;
        $this->request = $request;
    }

    public function isBlogListing()
    {
        $currentPath = $this->request->getFullActionName();

        return $currentPath == 'blog_index_index';
    }

    public function getPostCategory($postId)
    {
        $connection = $this->resourceConnection->getConnection();

        $select = $connection
            ->select()
            ->from(array('mbpc' => $connection->getTableName('magefan_blog_post_category')))
            ->where('post_id = ?', $postId)
            ->columns('mbpc.category_id');

        foreach ($connection->fetchAll($select) as $post) {
            if ($categoryId = $post['category_id']) {
                if  ($category = $this->categoryRepository->getById($categoryId)) {
                    return $category;
                }
                return false;
            }
        }

        return false;
    }

    public function getBlogBaseUrl()
    {
        $blogUrlIdentifier = $this->getWebsiteValue('mfblog/permalink/route');

        return $this->template->getUrl($blogUrlIdentifier);
    }

    public function getBlogCategories()
    {
        $searchCriteria = $this->searchCriteria->setFilterGroups([]);

        return $this->categoryRepository->getList($searchCriteria)->getItems();
    }

    public function getBlogCategoryUrl($category)
    {
        $blogUrl = $this->template->getUrl($this->getWebsiteValue('mfblog/permalink/route'));
        $categoryRoute = $this->getWebsiteValue('mfblog/permalink/category_route');

        return $blogUrl . $categoryRoute . '/' . $category['identifier'];
    }

    public function getBlogTopBannerImage()
    {
        return $this->getImage($this->getWebsiteValue('mfblog/index_page/top_banner_image'));
    }

    public function getBlogTopBannerText()
    {
        return $this->getWebsiteValue('mfblog/index_page/top_banner_text');
    }

    public function getImage($path)
    {
        if (!$path) {
            return false;
        }

        $mediaUrl = $this->storeManager->getStore()->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA);

        return $mediaUrl . 'banners/' . $path;
    }

    /**
     * @param $filename
     * @return bool
     */
    protected function _fileExists($filename)
    {
        if ($this->mediaDirectory->isFile($filename)) {
            return true;
        }
        return false;
    }

    /**
     * @param $image
     * @param null $width
     * @param null $height
     * @return string
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function resize($image, $width = null)
    {
        $mediaFolder = self::DIRECTORY;

        $path = 'magefan_blog/cache';
        if ($width !== null) {
            $path .= '/' . $width . 'x';
        }

        $absolutePath = $this->mediaDirectory->getAbsolutePath($mediaFolder) . $image;
        $imageResized = $this->mediaDirectory->getAbsolutePath($path) . $image;

        try {
            if (!$this->_fileExists($path . $image)) {
                $imageFactory = $this->imageFactory->create();
                $imageFactory->open($absolutePath);
                $imageFactory->constrainOnly(true);
                $imageFactory->keepTransparency(true);
                $imageFactory->keepFrame(false);
                $imageFactory->keepAspectRatio(true);
                $imageFactory->resize($width);
                $imageFactory->save($imageResized);
            }
            return $this->storeManager->getStore()->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA) . $path . $image;
        } catch (\Exception $e) {
            $this->_logger->error($e->getMessage());
        }

        return $image;
    }

    public function getPost()
    {
        return $this->registry->registry('current_blog_post');
    }

    public function getWebsiteValue($path)
    {
        return $this->scopeConfig->getValue($path, \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
    }

    public function getBlogTitle()
    {
        return $this->getWebsiteValue('mfblog/index_page/title');
    }
}
