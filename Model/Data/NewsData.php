<?php

namespace Aw\Test\Model\Data;

use Aw\Test\Api\Data\NewsInterface;
use Aw\Test\Model\AbstractTypifiedModel;
use Aw\Test\Model\ResourceModel\NewsResource;
use Aw\Test\Model\ResourceModel\NewsModel\NewsCollection;
use Magento\Framework\DataObject;

/**
 * @method NewsResource getResource()
 * @method NewsCollection getCollection()
 */
class NewsData extends AbstractTypifiedModel implements NewsInterface
{
    /**
     * Getter for NewsId.
     *
     * @return int|null
     */
    public function getNewsId(): ?int
    {
        return $this->getData(self::NEWS_ID) === null ? null
            : (int)$this->getData(self::NEWS_ID);
    }

    /**
     * Setter for NewsId.
     *
     * @param int|null $newsId
     *
     * @return void
     */
    public function setNewsId(?int $newsId): void
    {
        $this->setData(self::NEWS_ID, $newsId);
    }

    /**
     * Getter for Title.
     *
     * @return string
     */
    public function getTitle(): string
    {
        return $this->getData(self::TITLE);
    }

    /**
     * Setter for Title.
     *
     * @param string $title
     *
     * @return void
     */
    public function setTitle(string $title): void
    {
       $this->setData(self::TITLE, $title);
    }

    /**
     * Getter for Title.
     *
     * @return bool
     */
    public function getStatus(): bool
    {
        return $this->getData(self::STATUS);
    }

    /**
     * Setter for Status.
     *
     * @param bool $status
     *
     * @return void
     */
    public function setStatus(bool $status): void
    {
        $this->setData(self::STATUS, $status);
    }

    /**
     * Getter for Date.
     *
     * @return string
     */
    public function getDate(): string
    {
        return $this->getData(self::DATE);
    }

    /**
     * Setter for Date.
     *
     * @param string $date
     *
     * @return void
     */
    public function setDate(string $date): void
    {
        $this->setData(self::DATE, $date);
    }
}
