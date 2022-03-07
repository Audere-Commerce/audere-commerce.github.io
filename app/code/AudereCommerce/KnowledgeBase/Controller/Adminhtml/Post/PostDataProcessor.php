<?php

namespace AudereCommerce\KnowledgeBase\Controller\Adminhtml\Post;

use Magento\Framework\Message\ManagerInterface;

class PostDataProcessor
{

    /**
     * @var ManagerInterface
     */
    protected $_messageManager;

    /**
     * @param ManagerInterface $messageManager
     */
    public function __construct(ManagerInterface $messageManager)
    {
        $this->_messageManager = $messageManager;
    }

    /**
     * @param array $data
     */
    public function filter(array $data)
    {
        $filter = new \Zend_Filter_Input(array(), array(), $data);
        return $filter->getEscaped();
    }

    /**
     * @param array $data
     */
    public function validate(array $data)
    {
        return true;
    }

    /**
     * @param array $data
     */
    public function validateRequireEntry(array $data)
    {
        $requiredFields = array(
            'title' => __('Title')
        );

        $valid = true;

        foreach ($data as $field => $value) {
            if (in_array($field, array_keys($requiredFields)) && $value == '') {
                $valid = false;
                $this->_messageManager->addErrorMessage(__('To apply changes you should fill in required "%1" field', $requiredFields[$field]));
            }
        }

        return $valid;
    }
}
