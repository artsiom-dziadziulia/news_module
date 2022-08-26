<?php

namespace Aw\Test\Model\Data;

use Aw\Test\Api\NewsStoreDataInterface;

class NewsStoreData extends \Magento\Framework\DataObject implements NewsStoreDataInterface
{
    public const SCOPE_CODE = 'store';
    public const STORE_ID = 'store_id';

    /**
     * @return int
     */
    public function getStoreId(): int
    {
        return (int)$this->_getData(NewsStoreDataInterface::SCOPE_ID);
    }

    /**
     * @param int $storeId
     */
    public function setStoreId(int $storeId): void
    {
        $this->setData(NewsStoreDataInterface::SCOPE_ID, $storeId);
    }

    /**
     * @return int
     */
    public function getNewsItemId(): int
    {
        return (int)$this->_getData(NewsStoreDataInterface::NEWS_ITEM_ID);
    }

    /**
     * @param int $newsItemId
     */
    public function setNewsItemId(int $newsItemId): void
    {
        $this->setData(NewsStoreDataInterface::NEWS_ITEM_ID, $newsItemId);
    }

    /**
     * @return bool|int|string|null
     */
    public function getScopeValue(): bool|int|string|null
    {
        return $this->getStoreId();
    }

    /**
     * @param bool|int|string|null $scopeValue
     */
    public function setScopeValue($scopeValue): void
    {
        $this->setStoreId($scopeValue);
    }

    /**
     * @return int|null
     */
    public function getStore(): ?int
    {
        $data = $this->_getData(self::STORE_ID);
        if ($data === null) {
            return null;
        }

        return (int)$data;
    }

    /**
     * @param int|null $storeId
     *
     * @return void
     */
    public function setStore(?int $storeId): void
    {
        $this->setData(self::STORE_ID, $storeId);
    }
}