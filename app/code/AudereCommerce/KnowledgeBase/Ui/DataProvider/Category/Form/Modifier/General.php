<?php

namespace AudereCommerce\KnowledgeBase\Ui\DataProvider\Category\Form\Modifier;

use AudereCommerce\KnowledgeBase\Model\CategoryRepository;
use Magento\Catalog\Ui\DataProvider\Product\Form\Modifier\AbstractModifier;
use Magento\Framework\UrlInterface;
use Magento\Ui\Component\Form\Element\Checkbox;
use Magento\Ui\Component\Form\Element\Input;
use Magento\Ui\Component\Form\Element\Wysiwyg;
use Magento\Ui\Component\Form\Field;
use Magento\Ui\Component\Form\Fieldset;
use Magento\Ui\Component\Form\Element\Select;
use Magento\Framework\App\Config\ScopeConfigInterface;

class General extends AbstractModifier
{
    /**
     * @var CategoryRepository
     */
    protected $_categoryRepository;

    /**
     * @var UrlInterface
     */
    protected $_urlInterface;

    /**
     * @var ScopeConfigInterface
     */
    protected $_scopeConfig;

    /**
     * @param UrlInterface $urlInterface
     * @param CategoryRepository $categoryRepository
     */
    public function __construct(
        UrlInterface $urlInterface,
        CategoryRepository $categoryRepository,
        ScopeConfigInterface $scopeConfig
    )
    {
        $this->_urlInterface = $urlInterface;
        $this->_categoryRepository = $categoryRepository;
        $this->_scopeConfig = $scopeConfig;
    }

    /**
     * @param array $meta
     * @return array
     */
    public function modifyMeta(array $meta)
    {
        $meta['general'] = array(
            'arguments' => array(
                'data' => array(
                    'config' => array(
                        'componentType' => Fieldset::NAME,
                        'label' => __('General'),
                        'sortOrder' => 10,
                        'collapsible' => false,
                        'dataScope' => 'data.category'
                    )
                )
            ),
            'children' => array(
                'id' => array(
                    'arguments' => array(
                        'data' => array(
                            'config' => array(
                                'formElement' => 'hidden',
                                'label' => __('id'),
                                'componentType' => Field::NAME,
                                'source' => 'general',
                                'sortOrder' => 10
                            )
                        )
                    )
                ),
                'title' => array(
                    'arguments' => array(
                        'data' => array(
                            'config' => array(
                                'label' => __('Title'),
                                'componentType' => Field::NAME,
                                'formElement' => Input::NAME,
                                'source' => 'general',
                                'sortOrder' => 10,
                                'validation' => array(
                                    'required-entry' => '1'
                                )
                            )
                        )
                    )
                ),
                'parent_id' => array(
                    'arguments' => array(
                        'data' => array(
                            'config' => array(
                                'label' => __('Parent ID'),
                                'componentType' => Field::NAME,
                                'formElement' => Input::NAME,
                                'source' => 'general',
                                'sortOrder' => 15,
                                'required' => false
                            )
                        )
                    )
                ),
                'description' => array(
                    'arguments' => array(
                        'data' => array(
                            'config' => array(
                                'required' => false,
                                'label' => __('Description'),
                                'componentType' => Field::NAME,
                                'formElement' => Wysiwyg::NAME,
                                'template' => 'ui/form/field',
                                'wysiwyg' => true,
                                'source' => 'general',
                                'sortOrder' => 20,
                                'validation' => array(
                                    'required-entry' => '1'
                                ),
                            )
                        )
                    )
                ),
                'icon_image' => array(
                    'arguments' => array(
                        'data' => array(
                            'config' => array(
                                'required' => false,
                                'label' => __('Icon Image'),
                                'componentType' => Field::NAME,
                                'formElement' => 'imageUploader',
                                'source' => 'general',
                                'sortOrder' => 30,
                                'elementTmpl' => 'ui/form/element/uploader/uploader',
                                'previewTmpl' => 'Magento_Catalog/image-preview',
                                'uploaderConfig' => array(
                                    'url' => 'knowledgebase/post/imageUpload'
                                )
                            )
                        )
                    )
                ),
                'sort_order' => array(
                    'arguments' => array(
                        'data' => array(
                            'config' => array(
                                'label' => __('Sort Order'),
                                'componentType' => Field::NAME,
                                'formElement' => Input::NAME,
                                'source' => 'general',
                                'sortOrder' => 40,
                                'required' => false
                            )
                        )
                    )
                )
            )
        );

        return $meta;
    }

    /**
     * @param array $data
     * @return array
     */
    public function modifyData(array $data)
    {
        if (!empty($data)) {
            $id = array_keys($data)[0];
            $category = $this->_categoryRepository->getById($id);
        }


        return $data;
    }
}
