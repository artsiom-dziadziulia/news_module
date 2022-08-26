<?php

declare(strict_types=1);

namespace Aw\Test\Model\ResourceModel\NewsModel\JoinProcessor;

use Aw\Test\Model\ResourceModel\NewsResource;
use Magento\Framework\Api\SearchCriteria\CollectionProcessor\JoinProcessor\CustomJoinInterface;
use Magento\Framework\Data\Collection\AbstractDb;

class ScopeStore implements CustomJoinInterface
{
    /**
     * @param \Aw\Test\Model\ResourceModel\NewsModel\NewsCollection $collection
     * @return true
     */
    public function apply(AbstractDb $collection): bool
    {
        $collection->getSelect()->joinLeft(
            ['news_store' => $collection->getTable(NewsResource::SCOPE_STORE_TABLE)],
            'main_table.news_id = news_store.news_item_id',
            []
        );

        $collection->getSelect()->group('main_table.news_id');

        return true;
    }
}
