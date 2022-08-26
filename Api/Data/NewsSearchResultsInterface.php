<?php

declare(strict_types=1);

namespace Aw\Test\Api\Data;

/**
 * Search results of getList method of News
 */
interface NewsSearchResultsInterface extends \Magento\Framework\Api\SearchResultsInterface
{
    /**
     * Get source items list
     *
     * @return \Aw\Test\Api\Data\NewsInterface[]
     */
    public function getItems();

    /**
     * Set source items list
     *
     * @param \Aw\Test\Api\Data\NewsInterface[] $items
     * @return void
     */
    public function setItems(array $items);

    /**
     * Get items entity IDs
     *
     * @return int[]
     */
    public function getIds(): array;
}
