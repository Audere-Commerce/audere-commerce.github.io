<?php

namespace AudereCommerce\KnowledgeBase\Block\Adminhtml\Category\Edit;

use Magento\Backend\Block\Widget\Context;

class GenericButton
{

    /**
     * @var Context
     */
    protected $_context;

    /**
     * @param Context $context
     */
    public function __construct(Context $context)
    {
        $this->_context = $context;
    }

    /**
     * @param string $route
     * @param array $params
     * @return string
     */
    public function getUrl($route = '', array $params = array())
    {
        return $this->_context->getUrlBuilder()->getUrl($route, $params);
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->_context->getRequest()->getParam('id');
    }
}
