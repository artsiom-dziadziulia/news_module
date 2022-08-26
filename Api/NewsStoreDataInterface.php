<?php

declare(strict_types=1);

namespace Aw\Test\Api;

/**
 * News Store Data Interface.
 * News have many scope.
 * Data model interface.
 */
interface NewsStoreDataInterface
{
    /**
     * Constants defined for keys of data array
     */
    public const SCOPE_ID = 'store_id';
    public const NEWS_ITEM_ID = 'news_item_id';

    /**
     * Relation ID
     *
     * @return int
     */
    public function getStoreId(): int;

    /**
     * @param int $storeId
     *
     * @return void
     */
    public function setStoreId(int $storeId): void;

    /**
     * Related News ID
     *
     * @return int
     */
    public function getNewsItemId(): int;

    /**
     * @param int $newsItemId
     *
     * @return void
     */
    public function setNewsItemId(int $newsItemId): void;

    /**
     * @return string|int|bool
     */
    public function getScopeValue();

    /**
     * @param bool|int|string|null $scopeValue
     *
     * @return void
     */
    public function setScopeValue(bool|int|string|null $scopeValue): void;
}
