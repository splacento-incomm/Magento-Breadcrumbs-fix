<?php

namespace Debuglabs\Breadcrumbs\Block;

use Magento\Catalog\Helper\Data;
use Magento\Framework\View\Element\Template\Context;
use Magento\Store\Model\Store;
use Magento\Framework\Registry;

class Breadcrumbs extends \Magento\Theme\Block\Html\Breadcrumbs
{
    protected Data $_catalogData;
    protected Registry $registry;

    public function __construct(
        Context $context,
        Data $catalogData,
        Registry $registry,
        array $data = []
    ) {
        $this->_catalogData = $catalogData;
        $this->registry = $registry;
        parent::__construct($context, $data);
    }

    public function getTitleSeparator($store = null): string
    {
        $separator = (string)$this->_scopeConfig->getValue('catalog/seo/title_separator', \Magento\Store\Model\ScopeInterface::SCOPE_STORE, $store);
        return ' ' . $separator . ' ';
    }

    public function getCrumbs()
    {
        return $this->_crumbs;
    }

    protected function _prepareLayout()
    {
        $title = [];
        if ($breadcrumbsBlock = $this->getLayout()->getBlock('breadcrumbs')) {
            $breadcrumbsBlock->addCrumb(
                'home', [
                'label' => __('Home'),
                'title' => __('Go to Home Page'),
                'link' => $this->_storeManager->getStore()->getBaseUrl()
                ]
            );

            $path = $this->_catalogData->getBreadcrumbPath();
            $product = $this->registry->registry('current_product');

            if ($product && count($path) == 1) {
                $categoryCollection = clone $product->getCategoryCollection();
                $categoryCollection->clear();
                $categoryCollection->addAttributeToSort('level', $categoryCollection::SORT_ORDER_DESC)
                                   ->addAttributeToFilter('path', ['like' => "1/" . $this->_storeManager->getStore()->getRootCategoryId() . "/%"]);
                $categoryCollection->setPageSize(1);
                $breadcrumbCategories = $categoryCollection->getFirstItem()->getParentCategories();

                foreach ($breadcrumbCategories as $category) {
                    $catbreadcrumb = ["label" => $category->getName(), "link" => $category->getUrl()];
                    $breadcrumbsBlock->addCrumb("category" . $category->getId(), $catbreadcrumb);
                    $title[] = $category->getName();
                }

                $prodbreadcrumb = ["label" => $product->getName(), "link" => ""];
                $breadcrumbsBlock->addCrumb("product" . $product->getId(), $prodbreadcrumb);
                $title[] = $product->getName();
            } else {
                foreach ($path as $name => $breadcrumb) {
                    $breadcrumbsBlock->addCrumb($name, $breadcrumb);
                    $title[] = $breadcrumb['label'];
                }
            }
            $this->pageConfig->getTitle()->set(join($this->getTitleSeparator(), array_reverse($title)));
            return parent::_prepareLayout();
        }

        $path = $this->_catalogData->getBreadcrumbPath();
        foreach ($path as $name => $breadcrumb) {
            $title[] = $breadcrumb['label'];
        }
        $this->pageConfig->getTitle()->set(join($this->getTitleSeparator(), array_reverse($title)));
        return parent::_prepareLayout();
    }
}

