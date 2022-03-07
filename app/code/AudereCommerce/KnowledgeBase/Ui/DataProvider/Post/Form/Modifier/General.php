<?php

namespace AudereCommerce\KnowledgeBase\Ui\DataProvider\Post\Form\Modifier;

use AudereCommerce\KnowledgeBase\Model\Post\CategoryId\Options as CategoryIdOptions;
use AudereCommerce\KnowledgeBase\Model\PostRepository;
use Magento\Catalog\Ui\DataProvider\Product\Form\Modifier\AbstractModifier;
use Magento\Framework\UrlInterface;
use Magento\Ui\Component\Form\Element\Input;
use Magento\Ui\Component\Form\Element\Select;
use Magento\Ui\Component\Form\Element\Textarea;
use Magento\Ui\Component\Form\Element\Wysiwyg;
use Magento\Ui\Component\Form\Field;
use Magento\Ui\Component\Form\Fieldset;
use Magento\Store\Model\StoreManagerInterface;

class General extends AbstractModifier
{

    protected $_postRepository;

    /**
     * @var CategoryIdOptions
     */
    protected $_categoryIdOptions;

    /**
     * @var UrlInterface
     */
    protected $_urlInterface;

    protected $_storeManager;

    /**
     * @param UrlInterface $urlInterface
     * @param PostRepository $postRepository
     * @param CategoryIdOptions $categoryIdOptions
     */
    public function __construct(
        UrlInterface $urlInterface,
        PostRepository $postRepository,
        CategoryIdOptions $categoryIdOptions,
        StoreManagerInterface $storeManager
    )
    {
        $this->_urlInterface = $urlInterface;
        $this->_postRepository = $postRepository;
        $this->_categoryIdOptions = $categoryIdOptions;
        $this->_storeManager = $storeManager;
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
                        'dataScope' => 'data.post'
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
                'enabled' => array(
                    'arguments' => array(
                        'data' => array(
                            'config' => array(
                                'label' => __('Status'),
                                'componentType' => Field::NAME,
                                'formElement' => Select::NAME,
                                'source' => 'general',
                                'sortOrder' => 15,
                                'default' => 1,
                                'options' => array(
                                    array(
                                        'label' => __('Disabled'),
                                        'value' => 0
                                    ),
                                    array(
                                        'label' => __('Enabled'),
                                        'value' => 1
                                    )
                                )
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
                                'sortOrder' => 20,
                                'validation' => array(
                                    'required-entry' => '1'
                                )
                            )
                        )
                    )
                ),
                'url_key' => array(
                    'arguments' => array(
                        'data' => array(
                            'config' => array(
                                'label' => __('URL Key'),
                                'componentType' => Field::NAME,
                                'formElement' => Input::NAME,
                                'source' => 'general',
                                'sortOrder' => 25,
                                'notice' => __('Please ensure the URL key is unique.'),
                                'validation' => array(
                                    'required-entry' => '1'
                                )
                            )
                        )
                    )
                ),
                'category' => array(
                    'arguments' => array(
                        'data' => array(
                            'config' => array(
                                'label' => __('Category'),
                                'componentType' => Field::NAME,
                                'formElement' => Select::NAME,
                                'source' => 'general',
                                'sortOrder' => 30,
                                'validation' => array(
                                    'required-entry' => '1'
                                ),
                                'options' => $this->_categoryIdOptions->toOptionArray()
                            )
                        )
                    )
                ),
                'content' => array(
                    'arguments' => array(
                        'data' => array(
                            'config' => array(
                                'required' => false,
                                'label' => __('Content'),
                                'componentType' => Field::NAME,
                                'formElement' => Wysiwyg::NAME,
                                'template' => 'ui/form/field',
                                'wysiwyg' => true,
                                'source' => 'general',
                                'sortOrder' => 40,
                                'validation' => array(
                                    'required-entry' => '1'
                                ),
                            )
                        )
                    )
                ),
                'sort_order' => array(
                    'arguments' => array(
                        'data' => array(
                            'config' => array(
                                'formElement' => 'hidden',
                                'label' => __('Sort Order'),
                                'componentType' => Field::NAME,
                                'source' => 'general',
                                'sortOrder' => 50
                            )
                        )
                    )
                ),
            )
        );

        $meta['listing_information'] = array(
            'arguments' => array(
                'data' => array(
                    'config' => array(
                        'componentType' => Fieldset::NAME,
                        'label' => __('Listing Information (optional)'),
                        'sortOrder' => 30,
                        'collapsible' => true,
                        'dataScope' => 'data.post'
                    )
                )
            ),
            'children' => array(
                'short_description' => array(
                    'arguments' => array(
                        'data' => array(
                            'config' => array(
                                'required' => false,
                                'label' => __('Short Description'),
                                'componentType' => Field::NAME,
                                'formElement' => Wysiwyg::NAME,
                                'template' => 'ui/form/field',
                                'wysiwyg' => true,
                                'source' => 'general',
                                'sortOrder' => 10,
                            )
                        )
                    )
                ),
                'listing_image' => array(
                    'arguments' => array(
                        'data' => array(
                            'config' => array(
                                'required' => false,
                                'label' => __('Listing Image'),
                                'componentType' => Field::NAME,
                                'formElement' => 'imageUploader',
                                'source' => 'general',
                                'sortOrder' => 20,
                                'elementTmpl' => 'ui/form/element/uploader/uploader',
                                'previewTmpl' => 'Magento_Catalog/image-preview',
                                'uploaderConfig' => array(
                                    'url' => 'knowledgebase/post/imageUpload'
                                )
                            )
                        )
                    )
                )
            )
        );

        $meta['meta_data'] = array(
            'arguments' => array(
                'data' => array(
                    'config' => array(
                        'componentType' => Fieldset::NAME,
                        'label' => __('Meta Data (SEO)'),
                        'sortOrder' => 30,
                        'collapsible' => true,
                        'dataScope' => 'data.post'
                    )
                )
            ),
            'children' => array(
                'meta_title' => array(
                    'arguments' => array(
                        'data' => array(
                            'config' => array(
                                'label' => __('Meta Title'),
                                'componentType' => Field::NAME,
                                'formElement' => Input::NAME,
                                'source' => 'general',
                                'sortOrder' => 10,
                                'validation' => false
                            )
                        )
                    )
                ),
                'meta_description' => array(
                    'arguments' => array(
                        'data' => array(
                            'config' => array(
                                'required' => false,
                                'label' => __('Meta Description'),
                                'componentType' => Field::NAME,
                                'formElement' => Textarea::NAME,
                                'template' => 'ui/form/field',
                                'wysiwyg' => false,
                                'source' => 'general',
                                'sortOrder' => 20,
                            )
                        )
                    )
                ),
                'meta_keywords' => array(
                    'arguments' => array(
                        'data' => array(
                            'config' => array(
                                'label' => __('Meta Keywords'),
                                'componentType' => Field::NAME,
                                'formElement' => Input::NAME,
                                'source' => 'general',
                                'sortOrder' => 30,
                                'validation' => false
                            )
                        )
                    )
                ),
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
            $post = $this->_postRepository->getById($id);
            $mediaUrl = $this->_storeManager->getStore()->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA);

            $images = array(
                'main_image',
                'listing_image'
            );

            foreach ($images as $image) {
                if (isset($data[$id]['post'][$image])) {
                    $data[$id]['post'][$image] = array(array(
                        'url' => $mediaUrl . 'knowledgebase/post/' . $data[$id]['post'][$image],
                        'name' => $data[$id]['post'][$image]
                    ));
                }
            }
        }

        return $data;
    }
}
