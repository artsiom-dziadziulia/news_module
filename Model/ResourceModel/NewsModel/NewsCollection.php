<?php

namespace Aw\Test\Model\ResourceModel\NewsModel;

use Aw\Test\Model\NewsModel;
use Aw\Test\Model\ResourceModel\NewsResource;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

/**
 * @method \Aw\Test\Model\Data\NewsData[] getItems()
 */
class NewsCollection extends AbstractCollection
{
    /**
     * @var string
     */
    protected $_eventPrefix = 'news_collection';

    /**
     * Initialize collection model.
     */
    protected function _construct()
    {
        $this->_init(NewsModel::class, NewsResource::class);
    }
}
