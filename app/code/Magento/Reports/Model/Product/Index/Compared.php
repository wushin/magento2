<?php
/**
 * Copyright © 2015 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Magento\Reports\Model\Product\Index;

/**
 * Catalog Compared Product Index Model
 *
 * @method \Magento\Reports\Model\Resource\Product\Index\Compared _getResource()
 * @method \Magento\Reports\Model\Resource\Product\Index\Compared getResource()
 * @method \Magento\Reports\Model\Product\Index\Compared setVisitorId(int $value)
 * @method \Magento\Reports\Model\Product\Index\Compared setCustomerId(int $value)
 * @method int getProductId()
 * @method \Magento\Reports\Model\Product\Index\Compared setProductId(int $value)
 * @method \Magento\Reports\Model\Product\Index\Compared setStoreId(int $value)
 * @method string getAddedAt()
 * @method \Magento\Reports\Model\Product\Index\Compared setAddedAt(string $value)
 *
 * @author      Magento Core Team <core@magentocommerce.com>
 */
class Compared extends \Magento\Reports\Model\Product\Index\AbstractIndex
{
    /**
     * Cache key name for Count of product index
     *
     * @var string
     */
    protected $_countCacheKey = 'product_index_compared_count';

    /**
     * Catalog product compare
     *
     * @var \Magento\Catalog\Helper\Product\Compare
     */
    protected $_productCompare = null;

    /**
     * @param \Magento\Framework\Model\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param \Magento\Framework\Store\StoreManagerInterface $storeManager
     * @param \Magento\Customer\Model\Visitor $customerVisitor
     * @param \Magento\Customer\Model\Session $customerSession
     * @param \Magento\Framework\Session\Generic $reportSession
     * @param \Magento\Catalog\Model\Product\Visibility $productVisibility
     * @param \Magento\Framework\Stdlib\DateTime $dateTime
     * @param \Magento\Catalog\Helper\Product\Compare $productCompare
     * @param \Magento\Framework\Model\Resource\AbstractResource $resource
     * @param \Magento\Framework\Data\Collection\Db $resourceCollection
     * @param array $data
     * @SuppressWarnings(PHPMD.ExcessiveParameterList)
     */
    public function __construct(
        \Magento\Framework\Model\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\Store\StoreManagerInterface $storeManager,
        \Magento\Customer\Model\Visitor $customerVisitor,
        \Magento\Customer\Model\Session $customerSession,
        \Magento\Framework\Session\Generic $reportSession,
        \Magento\Catalog\Model\Product\Visibility $productVisibility,
        \Magento\Framework\Stdlib\DateTime $dateTime,
        \Magento\Catalog\Helper\Product\Compare $productCompare,
        \Magento\Framework\Model\Resource\AbstractResource $resource = null,
        \Magento\Framework\Data\Collection\Db $resourceCollection = null,
        array $data = []
    ) {
        parent::__construct(
            $context,
            $registry,
            $storeManager,
            $customerVisitor,
            $customerSession,
            $reportSession,
            $productVisibility,
            $dateTime,
            $resource,
            $resourceCollection,
            $data
        );
        $this->_productCompare = $productCompare;
    }

    /**
     * Initialize resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('Magento\Reports\Model\Resource\Product\Index\Compared');
    }

    /**
     * Retrieve Exclude Product Ids List for Collection
     *
     * @return array
     */
    public function getExcludeProductIds()
    {
        $productIds = [];
        if ($this->_productCompare->hasItems()) {
            foreach ($this->_productCompare->getItemCollection() as $_item) {
                $productIds[] = $_item->getEntityId();
            }
        }

        if ($this->_registry->registry('current_product')) {
            $productIds[] = $this->_registry->registry('current_product')->getId();
        }

        return array_unique($productIds);
    }
}
