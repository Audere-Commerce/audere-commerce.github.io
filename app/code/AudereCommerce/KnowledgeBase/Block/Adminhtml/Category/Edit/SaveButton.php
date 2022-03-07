<?php

namespace AudereCommerce\KnowledgeBase\Block\Adminhtml\Category\Edit;

use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;

class SaveButton extends GenericButton implements ButtonProviderInterface
{

    /**
     * @return array
     */
    public function getButtonData()
    {
        return array(
            'label' => __('Save'),
            'class' => 'save primary',
            'data_attribute' => array(
                'mage-init' => array(
                    'button' => array(
                        'event' => 'save'
                    )
                ),
                'form-role' => 'save'
            ),
            'sort_order' => 50
        );
    }
}
