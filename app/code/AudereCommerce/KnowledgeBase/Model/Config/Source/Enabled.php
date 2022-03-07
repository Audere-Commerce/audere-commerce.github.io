<?php

namespace AudereCommerce\KnowledgeBase\Model\Config\Source;

use Magento\Framework\App\Config\ScopeConfigInterface;

class Enabled implements \Magento\Framework\Option\ArrayInterface
{
    /**
     * @var ScopeConfigInterface
     */
    protected $_scopeConfig;

    public function __construct(
        ScopeConfigInterface $scopeConfig
    )
    {
        $this->_scopeConfig = $scopeConfig;
    }

    /**
     * Options getter
     *
     * @return array
     */
    public function toOptionArray()
    {
        return [['value' => 0, 'label' => 'Disabled'], ['value' => 1, 'label' => 'Enabled']];
    }

    /**
     * Get options in "key-value" format
     *
     * @return array
     */
    public function toArray()
    {
        return [0 => 'Disabled', 1 => 'Enabled'];
    }

    public function getWebsiteValue($path)
    {
        return $this->_scopeConfig->getValue($path, \Magento\Store\Model\ScopeInterface::SCOPE_WEBSITE);
    }
}
