<?php

namespace Aw\Test\Model;

use Aw\Test\Model\ResourceModel\NewsResource;
use Magento\Framework\Model\AbstractModel;

class NewsModel extends AbstractModel
{
    /**
     * @var string
     */
    protected $_eventPrefix = 'news_model';

    /**
     * Initialize magento model.
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(NewsResource::class);
    }
}
