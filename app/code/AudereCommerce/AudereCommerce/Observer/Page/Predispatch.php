<?php

namespace AudereCommerce\AudereCommerce\Observer\Page;

use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Event\Observer as Observer;
use Magento\Framework\View\Result\PageFactory;
use Magento\Catalog\Model\Layer\FilterList;
use Magento\Framework\View\Page\Config as PageConfig;
use Magento\Customer\Model\Session as CustomerSession;
use Magento\Framework\App\Response\RedirectInterface;
use Magento\Framework\App\Config\ScopeConfigInterface;

class Predispatch implements ObserverInterface
{
    /**
     * @var PageFactory
     */
    protected $_resultPageFactory;

    /**
     * @var FilterList
     */
    protected $_filterList;

    /**
     * @var PageConfig
     */
    protected $_pageConfig;

    /**
     * @var CustomerSession
     */
    protected $_customerSession;

    /**
     * @var RedirectInterface
     */
    protected $_redirect;

    /**
     * @var ScopeConfigInterface
     */
    protected $_scopeConfig;

    public function __construct(
        PageFactory $resultPageFactory,
        PageConfig $pageConfig,
        CustomerSession $customerSession,
        RedirectInterface $redirect,
        ScopeConfigInterface $scopeConfig
    )
    {
        $this->_resultPageFactory = $resultPageFactory;
        $this->_pageConfig = $pageConfig;
        $this->_customerSession = $customerSession;
        $this->_redirect = $redirect;
        $this->_scopeConfig = $scopeConfig;
    }

    public function execute(Observer $observer)
    {
        $currentPath = strtolower($observer->getRequest()->getFullActionName());
        $response = $observer->getControllerAction()->getResponse();

        $pathsAllowed = array(
            'cms_index_index',
            'contact_index_index',
            'cms_page_view'
        );

        if (!in_array($currentPath, $pathsAllowed)) {
            return $this->_redirect->redirect($response, '');
        }
    }

    public function getWebsiteValue($path)
    {
        return $this->_scopeConfig->getValue($path, \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
    }
}
