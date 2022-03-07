<?php

namespace AudereCommerce\KnowledgeBase\Block;

class Template extends \Magento\Framework\View\Element\Template
{
    public function getWebsiteValue($path)
    {
        return $this->_scopeConfig->getValue($path, \Magento\Store\Model\ScopeInterface::SCOPE_WEBSITE);
    }

    public function getTopFullwidthImage()
    {
        $mediaUrl = $this->_storeManager->getStore()->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA);

        return $mediaUrl . 'banners/' . $this->getWebsiteValue('knowledgebase/general/top_fullwidth_image');
    }
}
