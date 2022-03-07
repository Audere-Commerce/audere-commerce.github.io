<?php

namespace AudereCommerce\KnowledgeBase\Block\Adminhtml\Post\Edit;

use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;

class DeleteButton extends GenericButton implements ButtonProviderInterface
{

    /**
     * @return array
     */
    public function getButtonData()
    {
        return array(
            'label' => __('Delete'),
            'on_click' => 'deleteConfirm(\'' . __('Are you sure you want to do this?') . '\', \'' . $this->getUrl('*/*/delete', array('id' => $this->getId())) . '\')',
            'class' => 'delete',
            'sort_order' => 30
        );
    }
}
