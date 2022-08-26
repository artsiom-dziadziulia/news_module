<?php

declare(strict_types=1);

namespace Aw\Test\Model;

use Aw\Test\Api\Data\NewsSearchResultsInterface;
use Magento\Framework\Api\SearchResults;

/**
 * @method \Aw\Test\Api\Data\NewsInterface[] getItems()
 */
class NewsSearchResults extends SearchResults implements NewsSearchResultsInterface
{
    /**
     * @return int[]
     */
    public function getIds(): array
    {
        $ids = [];
        foreach ($this->getItems() as $item) {
            $ids[] = $item->getNewsId();
        }

        return $ids;
    }
}
